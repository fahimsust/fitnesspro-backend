<?php

namespace Domain\Products\Models\Product;

use Domain\Products\Models\OrderingRules\OrderingRule;
use Domain\Products\Models\Product\Pricing\PricingRule;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductsPricingTemp
 *
 * @property int $product_id
 * @property int $site_id
 * @property float $price_reg
 * @property float $price_sale
 * @property bool $onsale
 * @property int $min_qty
 * @property int $max_qty
 * @property bool $feature
 * @property int $pricing_rule_id
 * @property int $ordering_rule_id
 * @property bool $status
 *
 * @property OrderingRule $products_rules_ordering
 * @property PricingRule $pricing_rule
 * @property Product $product
 * @property Site $site
 *
 * @package Domain\Products\Models\Product
 */
class ProductPricingTemp extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'products_pricing_temp';

    protected $casts = [
        'product_id' => 'int',
        'site_id' => 'int',
        'price_reg' => 'float',
        'price_sale' => 'float',
        'onsale' => 'bool',
        'min_qty' => 'int',
        'max_qty' => 'int',
        'feature' => 'bool',
        'pricing_rule_id' => 'int',
        'ordering_rule_id' => 'int',
        'status' => 'bool',
    ];

    protected $fillable = [
        'product_id',
        'site_id',
        'price_reg',
        'price_sale',
        'onsale',
        'min_qty',
        'max_qty',
        'feature',
        'pricing_rule_id',
        'ordering_rule_id',
        'status',
    ];

    public function orderingRule()
    {
        return $this->belongsTo(OrderingRule::class, 'ordering_rule_id');
    }

    public function pricingRule()
    {
        return $this->belongsTo(PricingRule::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
