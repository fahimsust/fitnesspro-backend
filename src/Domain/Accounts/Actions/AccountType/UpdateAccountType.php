<?php

namespace Domain\Accounts\Actions\AccountType;

use App\Api\Admin\AccountType\Requests\AccountTypeRequest;
use Domain\Accounts\Models\AccountType;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateAccountType
{
    use AsObject;

    public function handle(
        AccountType $accountType,
        AccountTypeRequest $request
    ): AccountType {
        $accountType->update(
            [
                'name' => $request->name,
                'default_account_status' => $request->default_account_status,
                'filter_products' => $request->filter_products,
                'filter_categories' => $request->filter_categories,
                'affiliate_level_id' => $request->affiliate_level_id,
                'use_specialties' => $request->use_specialties,
                'membership_level_id' => $request->membership_level_id,
                'custom_form_id' => $request->custom_form_id,
                'loyaltypoints_id' => $request->loyaltypoints_id,
                'discount_level_id' => $request->discount_level_id,
                'email_template_id_creation_admin' => $request->email_template_id_creation_admin,
                'email_template_id_creation_user' => $request->email_template_id_creation_user,
                'email_template_id_activate_user' => $request->email_template_id_activate_user,
                'verify_user_email' => $request->verify_user_email,
            ]
        );

        return $accountType;
    }
}
