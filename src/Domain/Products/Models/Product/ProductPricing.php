<?php

namespace Domain\Products\Models\Product;


use Carbon\Carbon;
use Domain\Products\Actions\OrderingRules\LoadOrderingRuleByIdFromCache;
use Domain\Products\Actions\Pricing\LoadPricingRuleByIdFromCache;
use Domain\Products\Models\OrderingRules\OrderingRule;
use Domain\Products\Models\Product\Pricing\PricingRule;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;
use Support\Traits\BelongsTo\BelongsToProduct;
use Support\Traits\BelongsTo\BelongsToSite;
use Support\Traits\HasModelUtilities;

/**
 * Class ProductsPricing
 *
 * @property int $product_id
 * @property int $site_id
 * @property float $price_reg
 * @property float $price_sale
 * @property bool $onsale
 * @property float $min_qty
 * @property float $max_qty
 * @property bool $feature
 * @property int $pricing_rule_id
 * @property int $ordering_rule_id
 * @property bool $status
 * @property Carbon $published_date
 *
 * @property OrderingRule $products_rules_ordering
 * @property PricingRule $pricing_rule
 * @property Product $product
 * @property Site $site
 *
 * @package Domain\Products\Models\Product
 */
class ProductPricing extends Model
{
    use HasFactory, HasModelUtilities,
        BelongsToSite,
        BelongsToProduct;

    public const CREATED_AT = 'published_date';
    public const UPDATED_AT = null;

    protected $table = 'products_pricing';

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
        'published_date' => 'datetime',
    ];


    protected static function boot()
    {
        parent::boot();

        static::deleted(function (ProductPricing $pricing) {
            $pricing->clearCaches();
        });

        static::updated(function (ProductPricing $pricing) {
            $pricing->clearCaches();
        });
    }

    public function clearCaches()
    {
        Cache::tags([
            "product-pricing-cache.{$this->id}",
            "product-site-pricing-cache.{$this->product_id}.{$this->site_id}",
        ])->flush();
    }

    // protected function priceReg():Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => ConvertIntPriceToFloat::run($value),
    //     );
    // }
    // protected function priceSale(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => ConvertIntPriceToFloat::run($value),
    //     );
    // }
    public function priceReg(): float
    {
        return $this->price_reg;
    }

    public function priceSale(): float
    {
        return $this->price_sale;
    }

    public function usesTimestamps()
    {
        return true;
    }

    public function scopeForSite(
        Builder  $query,
        Site|int $site
    )
    {
        return $query
            ->whereSiteId(
                is_int($site)
                    ? $site
                    : $site->id
            )
            ->whereStatus(1);
    }

    public function price(): int
    {
        return $this->isOnSale()
            ? $this->salePrice()
            : $this->regularPrice();
    }

    public function regularPrice(): float
    {
        return $this->price_reg;
    }

    public function salePrice(): float
    {
        return $this->price_reg;
    }

    public function isOnSale(): bool
    {
        return $this->onsale;
    }

    public function minQty(): int
    {
        return $this->min_qty <= 0
            ? 1
            : $this->min_qty;
    }

    public function maxQty(): ?int
    {
        return $this->max_qty > 0
            ? $this->max_qty
            : null;
    }

    public function isActive(): bool
    {
        return $this->status;
    }

    public function hasOrderingRule(): bool
    {
        return (bool)$this->ordering_rule_id;
    }

    public function orderingRule(): BelongsTo
    {
        return $this->belongsTo(OrderingRule::class);
    }

    public function orderingRuleCached(): ?OrderingRule
    {
        if (!$this->ordering_rule_id) {
            return null;
        }

        return $this->orderingRule ??= LoadOrderingRuleByIdFromCache::now(
            $this->ordering_rule_id
        );
    }

    public function pricingRule(): BelongsTo
    {
        return $this->belongsTo(PricingRule::class);
    }

    public function pricingRuleCached(): ?PricingRule
    {
        if (!$this->pricing_rule_id) {
            return null;
        }

        return $this->pricingRule ??= LoadPricingRuleByIdFromCache::now(
            $this->pricing_rule_id
        );
    }
}
