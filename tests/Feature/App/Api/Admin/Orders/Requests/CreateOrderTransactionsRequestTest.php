<?php

namespace Tests\Feature\App\Api\Admin\Orders\Requests;

use App\Api\Admin\Orders\Requests\CreateOrderNoteRequest;
use App\Api\Admin\Orders\Requests\CreateOrderTransactionsRequest;
use Domain\Payments\Models\PaymentAccount;
use JMac\Testing\Traits\AdditionalAssertions;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardExpirationMonth;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardNumber;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CreateOrderTransactionsRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CreateOrderTransactionsRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CreateOrderTransactionsRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'charge_type' => ['required', 'in:1,2'],
                'cc_number' => ['required_if:charge_type,1', 'nullable', new CardNumber],
                'cc_exp_year' => [
                    'required_if:charge_type,1', 'nullable',
                    'string',
                    function ($attribute, $value, $fail) {
                        if ($this->get('charge_type') == 2) {
                            return;
                        }
                        $rule = new CardExpirationYear($this->get('cc_exp_month'));
                        if (!$rule->passes($attribute, $value)) {
                            $fail($rule->message());
                        }
                    },
                ],
                'cc_exp_month' => [
                    'required_if:charge_type,1', 'nullable',
                    'string',
                    function ($attribute, $value, $fail) {
                        if ($this->get('charge_type') == 2) {
                            return;
                        }
                        $rule = new CardExpirationMonth($this->get('cc_exp_year'));
                        if (!$rule->passes($attribute, $value)) {
                            $fail($rule->message());
                        }
                    },
                ],
                'charge_cvv' => [
                    'required_if:charge_type,1', 'nullable',

                    'string',
                    function ($attribute, $value, $fail) {
                        if ($this->get('charge_type') == 2) {
                            return;
                        }
                        $rule = new CardCvc($this->get('cc_number'));
                        if (!$rule->passes($attribute, $value)) {
                            $fail($rule->message());
                        }
                    },
                ],
                'note' => ['nullable', 'string'],
                'check_number' => ['required_if:charge_type,2', 'nullable', 'string'],
                'amount' => ['required', 'numeric'],
                'gateway_account_id' => ['int', 'exists:' . PaymentAccount::Table() . ',id', 'required'],
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
