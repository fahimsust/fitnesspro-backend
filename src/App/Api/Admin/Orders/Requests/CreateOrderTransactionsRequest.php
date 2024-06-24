<?php

namespace App\Api\Admin\Orders\Requests;

use Domain\Payments\Models\PaymentAccount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardNumber;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardExpirationMonth;

class CreateOrderTransactionsRequest extends FormRequest
{
    use HasFactory;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'charge_type' => ['required', 'in:1,2'],
            'cc_number' => ['required_if:charge_type,1', 'nullable', new CardNumber],
            'cc_exp_year' => [
                'required_if:charge_type,1', 'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    if ($this->get('charge_type') == 2) {
                        return;
                    }

                    // Apply the CardExpirationYear rule
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

                    // Apply the CardExpirationMonth rule
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

                    // Apply the CardExpirationMonth rule
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
        ];
    }
}
