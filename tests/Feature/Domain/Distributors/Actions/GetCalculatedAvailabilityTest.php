<?php

namespace Tests\Feature\Domain\Distributors\Actions;

use Domain\Distributors\Actions\GetCalculatedAvailability;
use Domain\Distributors\Models\Distributor;
use Domain\Distributors\Models\DistributorAvailability;
use Domain\Products\Models\Product\ProductAvailability;
use Tests\TestCase;

class GetCalculatedAvailabilityTest extends TestCase
{
    /** @test */
    public function can_get_calculated_availability()
    {
        $inStock = DistributorAvailability::factory()->create([
            'availability_id' => ProductAvailability::factory([
                'qty_min' => 1,
                'auto_adjust' => 1,
            ]),
        ]);

        $outOfStock = DistributorAvailability::factory()->create([
            'availability_id' => ProductAvailability::factory([
                'auto_adjust' => 1,
                'qty_max' => 0
            ]),
        ]);


        $distributor = Distributor::first();

        $this->assertEquals(
            $inStock->availability_id,
            GetCalculatedAvailability::run($distributor->id, 1)->id
        );

        $this->assertEquals(
            $outOfStock->availability_id,
            GetCalculatedAvailability::run($distributor->id, 0)->id
        );
    }
}
