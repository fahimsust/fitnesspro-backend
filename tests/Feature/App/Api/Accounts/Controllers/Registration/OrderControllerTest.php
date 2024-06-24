<?php

namespace Tests\Feature\App\Api\Accounts\Controllers\Registration;

use App\Api\Payments\Requests\CimPaymentProfileRequest;
use App\Api\Payments\Requests\PaypalCheckoutRequest;
use Domain\Accounts\Actions\Registration\Order\CreateOrderFromRegistration;
use Domain\Accounts\Models\Cim\CimPaymentProfile;
use Domain\Accounts\Models\Membership\SubscriptionPaymentOption;
use Domain\Orders\Enums\Order\OrderPaymentStatuses;
use Domain\Orders\Enums\Order\OrderStatuses;
use Domain\Payments\Enums\PaymentMethodActions;
use Domain\Payments\Services\AuthorizeNet\Actions\MockApiResponse;
use net\authorize\api\contract\v1\CreateTransactionResponse;
use Tests\Feature\Domain\Payments\Services\AuthorizeNet\Traits\UsesAuthorizeNetApiClient;
use Tests\Feature\Domain\Payments\Services\PaypalCheckout\Traits\UsesPaypalCheckoutApiClient;
use Tests\Feature\Traits\TestsRegistration;
use Tests\TestCase;


class OrderControllerTest extends TestCase
{
    use UsesAuthorizeNetApiClient;
    use UsesPaypalCheckoutApiClient;
    use TestsRegistration;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createRegistrationReadyToPlaceOrder();

        $this->session([
            'registrationId' => $this->registration->id,
        ]);
    }

    /** @test */
    public function can_store_using_passive_payment()
    {
        $response = $this->postJson(
            route('registration.order.store')
        )
            ->assertCreated()
            ->assertJsonStructure([
                'order' => [
                    'id',
                    'order_no',
                    'status',
                ]
            ]);

        $this->assertEquals(
            OrderStatuses::Completed->value,
            $response->json('order.status')
        );
    }

    /** @test */
    public function can_store_using_non_jumping_payment()
    {
        $this->mockExecuteApi()
            ->once()
            ->andReturn(MockApiResponse::now(
                new CreateTransactionResponse,
                <<<EOD
{"transactionResponse":{"responseCode":"1","authCode":"000000","avsResultCode":"Y","cvvResultCode":"P","cavvResultCode":"2","transId":"40109582555","refTransID":"","transHash":"","testRequest":"0","accountNumber":"XXXX0015","accountType":"MasterCard","messages":[{"code":"1","description":"This transaction has been approved."}],"transHashSha2":"","profile":{"customerProfileId":"508168897","customerPaymentProfileId":"513137419"},"SupplementalDataQualificationIndicator":0,"networkTransId":"00000000000000000000000"},"refId":"TEST-REF-001","messages":{"resultCode":"Ok","message":[{"code":"I00001","text":"Successful."}]}}
EOD
            ));

        $this->registration->update([
            'payment_method_id' => 1,//authnet cim
        ]);

        $this->createSubscriptionPaymentOptionUsingRegistration();

        $paymentProfile = CimPaymentProfile::firstOrFactory([
            'cc_exp' => now()->addDays(60)
        ]);

        $response = $this->postJson(
            route('registration.order.store'),
            (new CimPaymentProfileRequest([
                'payment_profile_id' => $paymentProfile->id
            ]))->toArray()
        )
            ->assertCreated()
            ->assertJsonStructure([
                'order'
            ]);

        $this->assertEquals(
            OrderStatuses::Completed->value,
            $response->json('order.status')
        );
    }

    /** @test */
    public function can_store_using_jumping_payment()
    {
        $this->mockCreateOrderResponse();

        $this->createAccount("dummy-token");

        $this->registration->update([
            'payment_method_id' => PaymentMethodActions::PaypalProExpress->value,
        ]);

        $option = SubscriptionPaymentOption::where(
            'payment_method_id',
            PaymentMethodActions::PaypalProExpress->value
        )
            ->where('site_id', $this->registration->site_id)
            ->first();

        $option->update([
            'gateway_account_id' => $this->paymentAccount->id
        ]);

        $response = $this->postJson(
            route('registration.order.store'),
            (new PaypalCheckoutRequest())->toArray()
        )
            ->assertAccepted()
            ->assertJsonStructure([
                'jump_to',
                'order'
            ]);

        $this->assertEquals(
            OrderStatuses::Recorded,
            $this->registration->fresh()->orderCached()->status
        );
    }

    /** @test */
    public function can_complete_jump_payment_order()
    {
        $this->registration->update([
            'payment_method_id' => PaymentMethodActions::PaypalProExpress->value,
        ]);

        $order = CreateOrderFromRegistration::now($this->registration);
        $order->update([
            'payment_status' => OrderPaymentStatuses::Approved,
            'status' => OrderStatuses::PaymentArranged
        ]);

        $response = $this->putJson(
            route('registration.order.complete'),
            [
                'registration_id' => $this->registration->id,
            ]
        )
            ->assertCreated()
            ->assertJsonStructure([
                'order'
            ]);

        $this->assertEquals(
            OrderStatuses::Completed,
            $this->registration->fresh()->orderCached()->status
        );
    }

    /** @todo */
    public function can_handle_if_order_already_setup_on_registration()
    {

    }

    /** @todo */
    public function fails_if_order_status_not_ready()
    {

    }

    /** @todo */
    public function fails_if_payment_fails()
    {

    }

    /** @todo */
    public function fails_if_registration_id_missing()
    {

    }

    /** @todo */
    public function fails_if_registration_has_no_cart()
    {

    }
}
