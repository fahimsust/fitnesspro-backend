<?php

namespace Tests\Feature\App\Api\Admin\Sites\Requests;

use App\Api\Admin\Sites\Requests\CheckoutPaymentMethodRequest;
use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CheckoutPaymentMethodRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CheckoutPaymentMethodRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CheckoutPaymentMethodRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'payment_method_id' => ['numeric', 'exists:' . PaymentMethod::Table() . ',id', 'required'],
                'gateway_account_id' => ['numeric', 'exists:' . PaymentAccount::Table() . ',id', 'required'],
                'fee' => ['numeric', 'nullable']
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
