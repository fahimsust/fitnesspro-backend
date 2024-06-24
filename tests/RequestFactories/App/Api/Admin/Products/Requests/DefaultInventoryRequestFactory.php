<?php

namespace Tests\RequestFactories\App\Api\Admin\Products\Requests;

use Domain\Distributors\Models\Distributor;
use Domain\Products\Models\FulfillmentRules\FulfillmentRule;
use Domain\Products\Models\Product\ProductAvailability;
use Worksome\RequestFactories\RequestFactory;

class DefaultInventoryRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'default_outofstockstatus_id' => ProductAvailability::firstOrFactory()->id,
            'default_distributor_id' => Distributor::firstOrFactory()->id,
            'default_cost' => $this->faker->randomDigit,
            'fulfillment_rule_id'=>FulfillmentRule::firstOrFactory()->id,
            'inventoried'=>$this->faker->boolean,
        ];
    }
}
