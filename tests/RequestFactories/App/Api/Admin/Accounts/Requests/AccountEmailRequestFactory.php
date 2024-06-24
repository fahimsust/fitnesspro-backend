<?php

namespace Tests\RequestFactories\App\Api\Admin\Accounts\Requests;

use Domain\Accounts\Models\Account;
use Domain\Messaging\Models\MessageTemplate;
use Worksome\RequestFactories\RequestFactory;

class AccountEmailRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        $faker = $this->faker;
        return [
            'account_id' => Account::firstOrFactory()->id,
            'subject' => $faker->word,
            'template_id' => MessageTemplate::firstOrFactory()->id,
            'body' => $faker->sentence,
        ];
    }
}
