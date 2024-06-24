<?php

namespace App\Api\Admin\Affiliates\Requests;

use App\Api\Addresses\Requests\AddressRequest;
use Domain\Accounts\Models\Account;
use Domain\Affiliates\Models\AffiliateLevel;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class UpdateAffiliateRequest extends AddressRequest
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
            'email' => ['string', 'email', 'max:85', 'required'],
            'password' => ['max:255', 'min:8', 'confirmed'],
            'name' => ['string', 'max:155', 'required'],
            'affiliate_level_id' => ['numeric', 'exists:' . AffiliateLevel::Table() . ',id', 'nullable'],
            'account_id' => ['numeric', 'exists:' . Account::Table() . ',id', 'nullable'],
        ];
    }
}
