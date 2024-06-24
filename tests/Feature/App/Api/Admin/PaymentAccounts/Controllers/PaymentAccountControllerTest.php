<?php

namespace Tests\Feature\App\Api\Admin\PaymentAccounts\Controllers;

use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentGateway;
use Domain\Payments\Models\PaymentMethod;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class PaymentAccountControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_payment_accounts_list()
    {
        PaymentAccount::factory(30)->create();

        $this->getJson(route('admin.payment-account.index'))
            ->assertOk()
            ->assertJsonStructure([ '*' => [
                    'id',
                    'name',
                ]
            ])
            ->assertJsonCount(30);
    }
    /** @test */
    public function can_get_payment_account_by_payment_method_list()
    {
        $gateway = PaymentGateway::factory()->create();
        $gateway2 = PaymentGateway::factory()->create();
        $paymentMethod = PaymentMethod::factory()->create(['gateway_id'=>$gateway->id]);
        PaymentMethod::factory()->create(['gateway_id'=>$gateway2->id]);
        PaymentAccount::factory(10)->create(['gateway_id'=>$gateway->id]);
        PaymentAccount::factory(10)->create(['gateway_id'=>$gateway2->id]);

        $this->getJson(route('admin.payment-account.index',['payment_method_id'=>$paymentMethod->id]))
            ->assertOk()
            ->assertJsonStructure([ '*' => [
                    'id',
                    'name',
                ]
            ])
            ->assertJsonCount(10);
    }
}
