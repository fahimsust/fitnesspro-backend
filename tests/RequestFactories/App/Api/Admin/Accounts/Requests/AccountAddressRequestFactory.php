<?php

namespace Tests\RequestFactories\App\Api\Admin\Accounts\Requests;


use Tests\RequestFactories\App\Api\Admin\Addresses\Requests\CreateAddressRequestFactory;

class AccountAddressRequestFactory extends CreateAddressRequestFactory
{
    public function definition(): array
    {
        return [
            'is_shipping' => true,
            'is_billing' => false,
            'status'=>1,
            'is_default_address'=>0
        ]+parent::definition();
    }
}
