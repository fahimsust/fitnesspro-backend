<?php

namespace Domain\Products\Models\OrderingRules;

use Domain\Accounts\Models\AccountType;
use Domain\Accounts\Models\Specialty;
use Domain\Products\Enums\OrderingConditionTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Enums\MatchAllAnyString;
use Support\Traits\HasModelUtilities;

class OrderingCondition extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $timestamps = false;

    protected $table = 'products_rules_ordering_conditions';

    protected $casts = [
        'rule_id' => 'int',
        'status' => 'bool',
        'type' => OrderingConditionTypes::class,
        'any_all' => MatchAllAnyString::class,
    ];

    protected $fillable = [
        'rule_id',
        'type',
        'status',
        'any_all',
    ];

    public function rule(): BelongsTo
    {
        return $this->belongsTo(
            OrderingRule::class,
            'rule_id'
        );
    }

    public function orderingConditionItem(): HasMany
    {
        return $this->hasMany(
            OrderingConditionItem::class,
            'condition_id'
        );
    }

    public function loadItems()
    {
        match ($this->type) {
            OrderingConditionTypes::REQUIRED_SPECIALTY => $this->load('specialties'),
            OrderingConditionTypes::REQUIRED_ACCOUNT_TYPE => $this->load('accountTypes')
        };
    }

//    public function scopeWithItems(Builder $query)
//    {
//        return $query
//            ->when(
//                $this->type == OrderingConditionTypes::REQUIRED_ACCOUNT_TYPE,
//                fn(Builder $query) => $query->with('accountTypes')
//            )
//            ->when(
//                $this->type == OrderingConditionTypes::REQUIRED_SPECIALTY,
//                fn(Builder $query) => $query->with('specialties')
//            );
//    }

    public function specialties(): belongsToMany
    {
        return $this->belongsToMany(
            Specialty::class,
            OrderingConditionItem::class,
            'condition_id',
            'item_id'
        );
    }

    public function accountTypes(): belongsToMany
    {
        return $this->belongsToMany(
            AccountType::class,
            OrderingConditionItem::class,
            'condition_id',
            'item_id'
        );
    }
}
