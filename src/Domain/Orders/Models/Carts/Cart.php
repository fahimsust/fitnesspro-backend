<?php

namespace Domain\Orders\Models\Carts;

use Domain\Accounts\Models\Registration\Registration;
use Domain\Discounts\Models\Discount;
use Domain\Orders\Enums\Cart\CartRelations;
use Domain\Orders\Enums\Cart\CartStatuses;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountAdvantage;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountCode;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Checkout\Checkout;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Support\Traits\BelongsTo\BelongsToAccount;
use Support\Traits\BelongsTo\BelongsToSite;
use Support\Traits\HasModelUtilities;

class Cart extends Model
{
    use HasModelUtilities,
        HasFactory,
        HasRelationships,
        BelongsToSite,
        BelongsToAccount;

    protected $table = 'cart';

    protected $casts = [
        'account_id' => 'int',
        'is_registration' => 'bool',
        'status' => CartStatuses::class,
    ];

    protected $fillable = [
        'account_id',
        'is_registration',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function (Cart $cart) {
            $cart->clearCaches();
        });

        static::updated(function (Cart $cart) {
            $cart->clearCaches();
        });
    }

    public function clearCaches(): void
    {
        Cache::tags([
            'cart-cache.' . $this->id,
        ])->flush();
    }

    public function cartDiscounts(): HasMany
    {
        return $this->hasMany(CartDiscount::class);
    }

    public function discounts(): HasManyThrough
    {
        return $this->hasManyThrough(
            Discount::class,
            CartDiscount::class,
            'cart_id',
            'id',
            'id',
            'discount_id'
        );
    }

    public function discountCodes(): HasManyThrough
    {
        return $this->hasManyThrough(
            CartDiscountCode::class,
            CartDiscount::class,
            'cart_id',
            'cart_discount_id',
            'id',
            'id',
        );
    }

    public function discountAdvantages(): HasManyThrough
    {
        return $this->hasManyThrough(
            CartDiscountAdvantage::class,
            CartDiscount::class,
            'cart_id',
            'cart_discount_id',
            'id',
            'id',
        );
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    public function products(): HasManyDeep
    {
        return $this->hasManyDeepFromRelations(
            $this->items(),
            (new CartItem)->product()
        );
    }

    public function options(): HasManyDeep
    {
        return $this->hasManyDeepFromRelations(
            $this->items(),
            (new CartItem)->optionValues()
        );
    }

    public function attributes(): HasManyDeep
    {
        return $this->hasManyDeepFromRelations(
            $this->products(),
            (new Product)->productAttributes()
        );
    }

    public function details(): HasManyDeep
    {
        return $this->hasManyDeepFromRelations(
            $this->products(),
            (new Product)->details()
        );
    }

    public function itemsCached(): Collection
    {
        return $this->items ??= Cache::tags([
            "cart-cache.{$this->id}",
        ])
            ->remember(
                'cart-items-by-cart-id.' . $this->id,
                60 * 5,
                fn() => $this->loadMissingReturn(CartRelations::ITEMS)
            );
    }

    public function isForRegistration(): bool
    {
        return $this->is_registration;
    }

    public function registration(): HasOne
    {
        if (!$this->isForRegistration()) {
            throw new \Exception('Cart is not for registration');
        }

        return $this->hasOne(
            Registration::class,
            'cart_id'
        );
    }

    public function checkout(): HasMany
    {
        return $this->hasMany(Checkout::class);
    }

    public function shipments(): HasManyDeep
    {
        return $this->hasManyDeepFromRelations(
            $this->checkout(),
            (new Checkout)->shipments()
        );
    }

    public function hasItems(): bool
    {
        return (bool)$this->items->count();
    }

    public function discountTotal(): float
    {
        return $this->discountAdvantages()
            ->withWhereHas(
                'advantage.discount',
                fn(Builder $query) => $query->active()
            )
            ->sum('amount');
    }

    public function itemsDiscountTotal(): float
    {
        return $this->items()
            ->select('cart_id')
            ->withSum(
                [
                    'discountAdvantages' => function ($query) {
                        return $query->select(DB::raw('SUM(qty * amount)'));
                    },
                ],
                'itemsDiscountTotal',
            )
            ->get()
            ->sum('discount_advantages_sum_items_discount_total');
        //            ->groupBy('cart_id')
        //            ->first('discount_advantages_sum_items_discount_total');
    }
    //
    //    public function itemsDiscountTotal(): int
    //    {
    //        return $this->items->sum(
    //            fn(CartItem $item) => $item->discountTotal()
    //        );
    //    }

    public function subTotal(): float
    {
        return $this->items->reduce(
            fn(?float $carry, CartItem $item) => bcadd(
                $carry,
                $item->totalAmount()
            ),
            0
        );
    }

    public function total(): float
    {
        $total = $this->subTotal() - $this->discountTotal();

        return $total > 0
            ? $total
            : 0;
    }

    public function weightTotal(): float
    {
        return $this->items->sum(
            fn(CartItem $item) => $item->weightTotal()
        );
    }

    public function isEmpty(): bool
    {
        return $this->items->isEmpty()
            && $this->discountAdvantages->isEmpty();
    }
}
