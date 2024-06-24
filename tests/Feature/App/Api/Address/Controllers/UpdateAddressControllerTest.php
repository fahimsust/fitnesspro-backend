<?php

namespace Tests\Feature\App\Api\Admin\Addresses\Controllers;

use App\Api\Admin\Addresses\Requests\CreateAddressRequest;
use Domain\Addresses\Models\Address;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class UpdateAddressControllerTest extends ControllerTestCase
{
    /** @test */
    public function can_update_address()
    {
        $address = Address::factory()->create();
        CreateAddressRequest::fake(['label' => 'test']);

        $this->putJson(route('account_address.update', [$address]))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals('test', $address->refresh()->label);
    }
}
