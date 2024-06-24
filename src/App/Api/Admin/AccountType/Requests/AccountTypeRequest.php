<?php

namespace App\Api\Admin\AccountType\Requests;

use Domain\Accounts\Models\LoyaltyPoints\LoyaltyProgram;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Affiliates\Models\AffiliateLevel;
use Domain\CustomForms\Models\CustomForm;
use Domain\Discounts\Models\Level\DiscountLevel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class AccountTypeRequest extends FormRequest
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
            'name' => ['string', 'max:55', 'required'],
            'default_account_status' => ['numeric','required'],
            'filter_products' => ['numeric','required'],
            'filter_categories' => ['numeric','required'],
            'affiliate_level_id' => ['numeric', 'exists:' . AffiliateLevel::Table() . ',id', 'nullable'],
            'use_specialties' => ['boolean','required'],
            'membership_level_id' => ['numeric', 'exists:' . MembershipLevel::Table() . ',id', 'nullable'],
            'custom_form_id' => ['numeric', 'exists:' . CustomForm::Table() . ',id', 'nullable'],
            'loyaltypoints_id' => ['numeric', 'exists:' . LoyaltyProgram::Table() . ',id', 'nullable'],
            'discount_level_id' => ['numeric', 'exists:' . DiscountLevel::Table() . ',id', 'nullable'],
            'email_template_id_creation_admin' => ['numeric','nullable'],
            'email_template_id_creation_user' => ['numeric','nullable'],
            'email_template_id_activate_user' => ['numeric','nullable'],
            'verify_user_email' => ['boolean','required'],
        ];
    }
}
