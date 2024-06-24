<?php

namespace Database\Factories\Domain\Accounts\Models;

use Domain\Accounts\Models\AccountStatus;
use Domain\Accounts\Models\AccountType;
use Domain\Messaging\Models\MessageTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AccountType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $messageTemplate = MessageTemplate::firstOrFactory();

        return [
            'name' => $this->faker->name,
            'default_account_status' => AccountStatus::firstOrFactory(),
            'custom_form_id' => null,
            'email_template_id_creation_admin' => $messageTemplate,
            'email_template_id_creation_user' => $messageTemplate,
            'email_template_id_activate_user' => $messageTemplate,
            'discount_level_id' => null,
            'filter_products' => 0,
            'filter_categories' => 0,
            'loyaltypoints_id' => null,
            'use_specialties' => 1,
            'membership_level_id' => null,
            'email_template_id_verify_email' => $messageTemplate,
            'affiliate_level_id' => null,
        ];
    }
}
