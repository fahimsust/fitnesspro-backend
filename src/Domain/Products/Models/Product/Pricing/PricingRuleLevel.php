<?php

namespace Domain\Products\Models\Product\Pricing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Support\Actions\ConvertIntPriceToFloat;
use Support\Enums\AmountAdjustmentTypes;
use Support\Traits\HasModelUtilities;

/**
 * Class PricingRulesLevel
 *
 * @property int $id
 * @property int $rule_id
 * @property int $min_qty
 * @property int $max_qty
 * @property bool $amount_type
 * @property float $amount
 *
 * @property PricingRule $pricing_rule
 *
 * @package Domain\Products\Models\Pricing;
 */
class PricingRuleLevel extends Model
{
    use HasFactory,
        HasModelUtilities;

    public $timestamps = false;

    protected $table = 'pricing_rules_levels';

    protected $casts = [
        'rule_id' => 'int',
        'min_qty' => 'int',
        'max_qty' => 'int',
        'amount_type' => AmountAdjustmentTypes::class,
        'amount' => 'float',
    ];

    protected $fillable = [
        'rule_id',
        'min_qty',
        'max_qty',
        'amount_type',
        'amount',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function (PricingRuleLevel $pricingRuleLevel) {
            Cache::tags([
                "pricing-rule-levels-cache.{$pricingRuleLevel->rule_id}",
            ])
                ->flush();
        });

        static::deleted(function (PricingRuleLevel $pricingRuleLevel) {
            $pricingRuleLevel->clearCaches();
        });

        static::updated(function (PricingRuleLevel $pricingRuleLevel) {
            $pricingRuleLevel->clearCaches();
        });
    }

    public function clearCaches(): void
    {
        Cache::tags([
            "pricing-rule-levels-cache.{$this->rule_id}",
            "pricing-rule-level-cache.{$this->id}"
        ])
            ->flush();
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function rule()
    {
        return $this->belongsTo(PricingRule::class, 'rule_id');
    }
}
