<?php

namespace Domain\Products\Models\Product\Pricing;

use Domain\Products\Actions\Pricing\LoadPricingRuleLevelsFromCache;
use Domain\Products\Actions\Pricing\LoadProductPricingForSiteFromCache;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Products\Models\Product\ProductPricingTemp;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Support\Traits\HasModelUtilities;

/**
 * Class PricingRule
 *
 * @property int $id
 * @property string $name
 *
 * @property Collection|array<PricingRuleLevel> $pricing_rules_levels
 * @property Collection|array<ProductPricing> $products_pricings
 * @property ProductPricingTemp $products_pricing_temp
 *
 * @package Domain\Products\Models\Pricing;
 */
class PricingRule extends Model
{
    use HasFactory,
        HasModelUtilities;

    public $timestamps = false;

    protected $table = 'pricing_rules';

    protected $fillable = [
        'name',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function (PricingRule $pricingRule) {
            $pricingRule->clearCaches();
        });

        static::updated(function (PricingRule $pricingRule) {
            $pricingRule->clearCaches();
        });
    }

    public function clearCaches()
    {
        Cache::tags([
            "pricing-rule-cache.{$this->id}",
        ])
            ->flush();
    }

    public function levels(): HasMany
    {
        return $this->hasMany(
            PricingRuleLevel::class,
            'rule_id'
        );
    }

    public function levelsCached(): Collection
    {
        return LoadPricingRuleLevelsFromCache::now(
            $this->id
        );
    }

    public function pricing(): HasMany
    {
        return $this->hasMany(ProductPricing::class);
    }
}
