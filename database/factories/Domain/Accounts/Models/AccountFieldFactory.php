<?php

namespace Database\Factories\Domain\Accounts\Models;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountField;
use Domain\CustomForms\Models\CustomField;
use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\FormSection;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AccountField::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_id' => function () {
                return Account::firstOrFactory()->id;
            },
            'form_id' => function () {
                return CustomForm::firstOrFactory()->id;
            },
            'section_id' => function () {
                return FormSection::firstOrFactory()->id;
            },
            'field_id' => function () {
                return CustomField::firstOrFactory()->id;
            },
            'field_value' => $this->faker->randomHtml(1),
        ];
    }
}
