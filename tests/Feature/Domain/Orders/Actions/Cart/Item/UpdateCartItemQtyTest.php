<?php

namespace Tests\Feature\Domain\Orders\Actions\Cart\Item;

use Domain\Distributors\Models\Distributor;
use Domain\Orders\Actions\Cart\Item\LoadProductWithEntitiesForCartItem;
use Domain\Orders\Dtos\CartItemDto;
use Domain\Products\Models\OrderingRules\OrderingRule;
use Domain\Products\Models\Product\Pricing\PricingRuleLevel;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAttribute;
use Domain\Products\Models\Product\ProductAvailability;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductDistributor;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Sites\Models\Site;
use Tests\TestCase;

class UpdateCartItemQtyTest extends TestCase
{
    //todo

    /** @todo */
    public function can_update()
    {

    }

    /** @todo */
    public function will_limit_to_availability_qty()
    {

    }

    /** @todo */
    public function will_fail_if_over_max_qty()
    {

    }

    /** @todo */
    public function will_fail_if_under_min_qty()
    {

    }

    /** @todo */
    public function will_apply_volume_pricing()
    {

    }

    /** @todo */
    public function will_update_linked_accessories()
    {

    }

    /** @todo */
    public function can_ignore_qty_limits()
    {

    }

    /** @todo */
    public function will_fail_if_qty_is_same_as_current()
    {

    }
}
