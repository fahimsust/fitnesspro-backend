<?php

namespace App\Api\Admin\Accounts\Requests;

use Domain\Accounts\Models\Account;
use Domain\Messaging\Models\MessageTemplate;
use Domain\Orders\Models\Order\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class AccountEmailRequest extends FormRequest
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

            'account_id' => ['numeric', 'exists:' . Account::Table() . ',id', 'required'],
            'message_template_id' => ['numeric', 'exists:' . MessageTemplate::Table() . ',id', 'nullable'],
            'subject' => ['string', 'max:55', 'required'],
            'body' => ['string', 'required'],
            'order_id' => ['numeric', 'exists:' . Order::Table() . ',id', 'nullable'],
        ];
    }
}
