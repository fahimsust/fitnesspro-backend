<?php

namespace Tests\RequestFactories\App\Api\Admin\Accounts\Requests;

use Domain\Accounts\Models\Account;

class CreateAccountAddressRequestFactory extends AccountAddressRequestFactory
{
    public function definition(): array
    {
        return [
            'account_id' => Account::firstOrFactory()->id
        ] + parent::definition();
    }
}
