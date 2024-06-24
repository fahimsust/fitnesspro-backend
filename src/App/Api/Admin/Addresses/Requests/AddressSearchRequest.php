<?php

namespace App\Api\Admin\Addresses\Requests;

use App\Api\Addresses\Requests\AddressRequest;
use Domain\Accounts\Models\Account;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class AddressSearchRequest extends AddressRequest
{
    use HasFactory;

    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    public function rules()
    {
        return [
            'account_id' => ['numeric', 'exists:' . Account::Table() . ',id', 'nullable'],
            'keyword' => ['string', 'required'],
        ];
    }
}
