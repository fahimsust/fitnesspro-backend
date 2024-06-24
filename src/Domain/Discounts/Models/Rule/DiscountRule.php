<?php

namespace Domain\Discounts\Models\Rule;

use Domain\Discounts\Contracts\CanBeCheckedForDiscount;
use Domain\Discounts\Models\Discount;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Enums\MatchAllAnyInt;
use Support\Traits\HasModelUtilities;

/**
 * Class DiscountRule
 *
 * @property int $id
 * @property int $discount_id
 * @property bool $match_anyall
 * @property int $rank
 *
 * @property Discount $discount
 * @property Collection|array<DiscountCondition> $discount_rule_conditions
 *
 * @package Domain\Orders\Models\Discount
 */
class DiscountRule extends Model implements CanBeCheckedForDiscount
{
    use HasModelUtilities, HasFactory;

    protected $table = 'discount_rule';

    protected $casts = [
        'discount_id' => 'int',
        'match_anyall' => MatchAllAnyInt::class,
        'rank' => 'int',
    ];

    protected $fillable = [
        'discount_id',
        'match_anyall',
        'rank',
    ];

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function conditions()
    {
        return $this->hasMany(DiscountCondition::class, 'rule_id');
    }
}
