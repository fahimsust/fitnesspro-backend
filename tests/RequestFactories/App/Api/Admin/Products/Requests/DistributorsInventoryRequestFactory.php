<?php

namespace Tests\RequestFactories\App\Api\Admin\Products\Requests;

use Domain\Distributors\Models\Distributor;
use Domain\Products\Models\Product\ProductAvailability;
use Worksome\RequestFactories\RequestFactory;

class DistributorsInventoryRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'outofstockstatus_id' => ProductAvailability::firstOrFactory()->id,
            'distributor_id' => Distributor::firstOrFactory()->id,
            'cost' => $this->faker->randomDigit,
            'stock_qty' => $this->faker->randomDigit,
        ];
    }
}
