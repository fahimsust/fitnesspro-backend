<?php

namespace Domain\Discounts\Models\Rule\Condition;

use Domain\Accounts\Models\AccountType;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Discounts\Enums\DiscountConditionRequiredQtyTypes;
use Domain\Discounts\Enums\DiscountConditionTypes;
use Domain\Discounts\Models\Rule\DiscountRule;
use Domain\Distributors\Models\Distributor;
use Domain\Locales\Models\Country;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAvailability;
use Domain\Products\Models\Product\ProductType;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Support\Enums\MatchAllAnyInt;
use Support\Traits\HasModelUtilities;

/**
 * Class DiscountRuleCondition
 *
 * @property int $id
 * @property int $rule_id
 * @property int $condition_type_id
 * @property float $required_cart_value
 * @property string $required_code
 * @property DiscountConditionRequiredQtyTypes $required_qty_type
 * @property int $required_qty_combined
 * @property MatchAllAnyInt $match_anyall
 * @property int $rank
 * @property bool $equals_notequals
 * @property bool $use_with_rules_products
 *
 * @property DiscountConditionTypes $discount_rule_condition_type
 * @property DiscountRule $discount_rule
 * @property Collection|array<ConditionAccountType> $discount_rule_condition_accounttypes
 * @property Collection|array<ConditionAttribute> $discount_rule_condition_attributes
 * @property Collection|array<ConditionCountry> $discount_rule_condition_countries
 * @property Collection|array<Distributor> $distributors
 * @property Collection|array<ConditionMembershipLevel> $discount_rule_condition_membershiplevels
 * @property Collection|array<ConditionOnSaleStatus> $discount_rule_condition_onsalestatuses
 * @property Collection|array<ConditionOutOfStockStatus> $discount_rule_condition_outofstockstatuses
 * @property Collection|array<ConditionProductAvailability> $discount_rule_condition_productavailabilities
 * @property Collection|array<Product> $products
 * @property Collection|array<ConditionProductType> $discount_rule_condition_producttypes
 * @property Collection|array<Site> $sites
 *
 * @package Domain\Orders\Models\Discount
 */
class DiscountCondition extends Model
{
    use HasModelUtilities,
        HasFactory;

    protected $table = 'discount_rule_condition';

    protected $casts = [
        'rule_id' => 'int',
        'condition_type_id' => DiscountConditionTypes::class,
        'required_cart_value' => 'float',
        'required_qty_type' => DiscountConditionRequiredQtyTypes::class,
        'required_qty_combined' => 'int',
        'match_anyall' => MatchAllAnyInt::class,
        'rank' => 'int',
        'equals_notequals' => 'bool',
        'use_with_rules_products' => 'bool',
        'type' => DiscountConditionTypes::class,
    ];

    protected $fillable = [
        'rule_id',
        'condition_type_id',
        'required_cart_value',
        'required_code',
        'required_qty_type',
        'required_qty_combined',
        'match_anyall',
        'rank',
        'equals_notequals',
        'use_with_rules_products',
    ];

    private array $cachedRelation = [];

    public function type(): Attribute
    {
        return new Attribute(
            get: fn() => $this->condition_type_id,
        );
    }

    public function rule(): BelongsTo
    {
        return $this->belongsTo(DiscountRule::class, 'rule_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            ConditionProduct::class,
            'condition_id',
            'product_id'
        )
            ->withPivot('required_qty', 'id');
    }

    public function sites(): BelongsToMany
    {
        return $this->belongsToMany(
            Site::class,
            ConditionSite::class,
            'condition_id',
            'site_id'
        )->withPivot('id');
    }

    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(
            Country::class,
            ConditionCountry::class,
            'condition_id',
            'country_id'
        )->withPivot('id');
    }

    public function attributeOptions()
    {
        return $this->belongsToMany(
            AttributeOption::class,
            ConditionAttribute::class,
            'condition_id',
            'attributevalue_id'
        )->withPivot('required_qty', 'id');
    }

    public function accountTypes(): BelongsToMany
    {
        return $this->belongsToMany(
            AccountType::class,
            ConditionAccountType::class,
            'condition_id',
            'accounttype_id'
        )->withPivot('id');
    }

    public function distributors(): BelongsToMany
    {
        return $this->belongsToMany(
            Distributor::class,
            ConditionDistributor::class,
            'condition_id',
            'distributor_id'
        )->withPivot('id');
    }

    public function productTypes(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductType::class,
            ConditionProductType::class,
            'condition_id',
            'producttype_id'
        )->withPivot('required_qty', 'id');
    }

    public function onSaleStatuses(): HasMany
    {
        return $this->hasMany(
            ConditionOnSaleStatus::class,
            'condition_id'
        );
    }

    public function membershipLevels(): BelongsToMany
    {
        return $this->belongsToMany(
            MembershipLevel::class,
            ConditionMembershipLevel::class,
            'condition_id',
            'membershiplevel_id'
        )->withPivot('id');
    }

    public function outOfStockStatuses(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductAvailability::class,
            ConditionOutOfStockStatus::class,
            'condition_id',
            'outofstockstatus_id'
        )->withPivot('required_qty', 'id');
    }

    public function cachedRelation(
        string $relation
    )
    {
        if(isset($this->cachedRelation[$relation])) {
            return $this->cachedRelation[$relation];
        }

        return Cache::tags([
            "discount-condition-cache:{$this->id}"
        ])
            ->remember(
                "discount-condition-{$this->id}-{$relation}",
                now()->addMinutes(1),
                fn() => $this->loadMissingReturn($relation)
            );
    }

    public function productAvailabilities(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductAvailability::class,
            ConditionProductAvailability::class,
            'condition_id',
            'availability_id'
        )->withPivot('required_qty', 'id');
    }

    public function checkEquals(): bool
    {
        return $this->equals_notequals == 0;
    }
}
