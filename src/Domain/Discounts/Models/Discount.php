<?php

namespace Domain\Discounts\Models;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountUsedDiscount;
use Domain\Discounts\Collections\DiscountCollection;
use Domain\Discounts\Contracts\CanBeCheckedForDiscount;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Rule\DiscountRule;
use Domain\Discounts\QueryBuilders\DiscountQuery;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderDiscount;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\OrderItems\OrderItemDiscount;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kirschbaum\PowerJoins\PowerJoins;
use Support\Enums\MatchAllAnyInt;
use Support\Traits\ClearsCache;
use Support\Traits\HasModelUtilities;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Discount
 *
 * @property int $id
 * @property string $name
 * @property string $display
 * @property Carbon $start_date
 * @property Carbon $exp_date
 * @property bool $status
 * @property int $limit_per_order
 * @property bool $match_anyall
 * @property string $random_generated
 * @property int $limit_uses
 * @property int $limit_per_customer
 *
 *
 * @property Collection|array<Account> $accounts
 * @property Collection|array<DiscountAdvantage> $discount_advantages
 * @property Collection|array<DiscountRule> $discount_rules
 * @property Collection|array<Order> $orders
 * @property Collection|array<OrderItem> $orders_products
 *
 * @package Domain\Orders\Models\Discount
 */
class Discount extends Model implements CanBeCheckedForDiscount
{
    use HasModelUtilities,
        SoftDeletes,
        HasFactory,
        PowerJoins,
        ClearsCache;

    protected $dates = ['deleted_at'];

    protected $table = 'discount';

    protected $casts = [
        'status' => 'bool',
        'limit_per_order' => 'int',
        'match_anyall' => MatchAllAnyInt::class,
        'limit_uses' => 'int',
        'limit_per_customer' => 'int',
        'start_date' => 'datetime',
        'exp_date' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'display',
        'start_date',
        'exp_date',
        'status',
        'limit_per_order',
        'match_anyall',
        'random_generated',
        'limit_uses',
        'limit_per_customer',
    ];

    protected function cacheTags(): array
    {
        return [
            "discount-cache.{$this->id}",
        ];
    }

    public function newCollection(array $models = [])
    {
        return new DiscountCollection($models);
    }
    public function newEloquentBuilder($query)
    {
        return new DiscountQuery($query);
    }

    public function scopeActive(Builder $query)
    {
        return $query->whereStatus(1);
    }

    public function accountUses()
    {
        return $this->hasMany(
            AccountUsedDiscount::class,
            'discount_id'
        );
    }

    public function usedByAccounts()
    {
        return $this->belongsToMany(
            Account::class,
            AccountUsedDiscount::class,
        )
            ->withPivot('order_id', 'times_used', 'used');
    }

    public function advantages(): HasMany
    {
        return $this->hasMany(DiscountAdvantage::class);
    }

    public function rules(): HasMany
    {
        return $this->hasMany(DiscountRule::class);
    }

    public function usedOnOrders()
    {
        //todo
        return $this->hasManyThrough(
            Order::class,
            OrderDiscount::class,
        )
            ->withPivot('discount_code');
    }

    public function usedOnOrderProducts()
    {
        //todo
        return $this->hasManyThrough(
            OrderItem::class,
            OrderItemDiscount::class,
            'discount_id',
            'orders_products_id'
        )
            ->withPivot('advantage_id', 'amount', 'qty', 'id');
    }
}
