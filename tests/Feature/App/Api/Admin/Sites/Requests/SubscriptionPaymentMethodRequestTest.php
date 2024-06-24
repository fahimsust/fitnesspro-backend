<?php

namespace Tests\Feature\App\Api\Admin\Sites\Requests;

use App\Api\Admin\Sites\Requests\SubscriptionPaymentMethodRequest;
use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class SubscriptionPaymentMethodRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private SubscriptionPaymentMethodRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new SubscriptionPaymentMethodRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'payment_method_id' => ['numeric', 'exists:' . PaymentMethod::Table() . ',id', 'required'],
                'gateway_account_id' => ['numeric', 'exists:' . PaymentAccount::Table() . ',id', 'required'],
            ],
            $this->request->rules()
        );
    }

    /** @test */
    public function can_authorize()
    {
        $this->createAndAuthAdminUser();

        $this->assertTrue($this->request->authorize());
    }
}
