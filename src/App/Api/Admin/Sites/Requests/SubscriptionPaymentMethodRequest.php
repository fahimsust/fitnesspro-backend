<?php

namespace App\Api\Admin\Sites\Requests;

use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SubscriptionPaymentMethodRequest extends FormRequest
{
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
            'payment_method_id' => ['numeric', 'exists:' . PaymentMethod::Table() . ',id', 'required'],
            'gateway_account_id' => ['numeric', 'exists:' . PaymentAccount::Table() . ',id', 'required'],
        ];
    }
}
