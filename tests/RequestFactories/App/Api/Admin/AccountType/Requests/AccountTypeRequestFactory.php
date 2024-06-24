<?php

namespace Tests\RequestFactories\App\Api\Admin\AccountType\Requests;

use Domain\Accounts\Models\AccountStatus;
use Domain\Messaging\Models\MessageTemplate;
use Worksome\RequestFactories\RequestFactory;

class AccountTypeRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        $messageTemplate = MessageTemplate::firstOrFactory()->id;

        return [
            'name' => $this->faker->name,
            'default_account_status' => AccountStatus::firstOrFactory()->id,
            'custom_form_id' => null,
            'email_template_id_creation_admin' => $messageTemplate,
            'email_template_id_creation_user' => $messageTemplate,
            'email_template_id_activate_user' => $messageTemplate,
            'discount_level_id' => null,
            'filter_products' => 0,
            'filter_categories' => 0,
            'loyaltypoints_id' => null,
            'verify_user_email'=>0,
            'use_specialties' => 1,
            'membership_level_id' => null,
            'email_template_id_verify_email' => $messageTemplate,
            'affiliate_level_id' => null,
        ];
    }
}
