<?php

namespace App\Api\Admin\Accounts\Requests;

use Domain\Accounts\Models\Account;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class CreateAccountAddressRequest extends AccountAddressRequest
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
            'account_id' => ['numeric', 'required', 'exists:' . Account::Table() . ',id'],
        ] + parent::rules();
    }
}
