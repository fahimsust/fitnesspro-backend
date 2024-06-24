<?php

namespace Domain\Products\Models\OrderingRules;

use Domain\Products\Models\DatesAutoOrderRules\DatesAutoOrderRuleAction;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Products\Models\Product\ProductPricingTemp;
use Domain\Products\QueryBuilders\OrderingRuleQuery;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Support\Enums\MatchAllAnyString;
use Support\Traits\HasModelUtilities;

/**
 * Class ProductsRulesOrdering
 *
 * @property int $id
 * @property string $name
 * @property bool $status
 * @property string $any_all
 *
 * @property Collection|array<DatesAutoOrderRuleAction> $mods_dates_auto_orderrules_actions
 * @property Collection|array<ProductPricing> $products_pricings
 * @property ProductPricingTemp $products_pricing_temp
 * @property Collection|array<OrderingRuleSubRule> $products_rules_ordering_rules
 *
 * @package Domain\Products\Models\Product
 */
class OrderingRule extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $timestamps = false;

    protected $table = 'products_rules_ordering';

    protected $casts = [
        'status' => 'bool',
        'any_all' => MatchAllAnyString::class,
    ];

    protected $fillable = [
        'name',
        'status',
        'any_all',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function (OrderingRule $orderingRule) {
            $orderingRule->clearCaches();
        });

        static::updated(function (OrderingRule $orderingRule) {
            $orderingRule->clearCaches();
        });
    }

    public function clearCaches(): void
    {
        Cache::tags([
            "ordering-rule-cache.{$this->id}"
        ])
            ->flush();
    }

    public function newEloquentBuilder($query)
    {
        return new OrderingRuleQuery($query);
    }

    public function datesAutoOrderRuleActionCriteria()
    {
        return $this->hasMany(
            DatesAutoOrderRuleAction::class,
            'criteria_orderingruleid'
        );
    }

    public function datesAutoOrderRuleActionUpdate()
    {
        return $this->hasMany(
            DatesAutoOrderRuleAction::class,
            'changeto_orderingruleid'
        );
    }

    public function pricing(): HasMany
    {
        return $this->hasMany(
            ProductPricing::class,
            'ordering_rule_id'
        );
    }

//  public function pricingTemp()
//  {
//      return $this->hasMany(ProductPricingTemp::class, 'ordering_rule_id');
//  }

    public function hasParentRules(): bool
    {
        return (bool) $this->parentRules->count();
    }

    public function parentRules()
    {
        return $this->hasMany(
            OrderingRuleSubRule::class,
            'child_rule_id'
        );
    }

    public function hasSubRules(): bool
    {
        return (bool) $this->subRules->count();
    }

    public function subRules()
    {
        return $this->hasMany(
            OrderingRuleSubRule::class,
            'parent_rule_id'
        );
    }
    public function childRules()
    {
        return $this->belongsToMany(
            OrderingRule::class,
            OrderingRuleSubRule::class,
            'parent_rule_id',
            'child_rule_id'
        );
    }

    public function hasConditions(): bool
    {
        return (bool) $this->conditions->count();
    }

    public function conditions()
    {
        return $this->hasMany(
            OrderingCondition::class,
            'rule_id'
        );
    }
    public function translations()
    {
        return $this->hasMany(
            OrderingRuleTranslation::class,
            'rule_id'
        );
    }
}
