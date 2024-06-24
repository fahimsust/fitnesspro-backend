<?php

namespace Tests\Feature\App\Api\Admin\PaymentMethods\Controllers;

use Domain\Payments\Models\PaymentMethod;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class PaymentMethodControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_payment_methods_list()
    {
        PaymentMethod::factory(30)->create();

        $this->getJson(route('admin.payment-method.index'))
            ->assertOk()
            ->assertJsonStructure([ '*' => [
                    'id',
                    'name',
                ]
            ])
            ->assertJsonCount(30);
    }
}
