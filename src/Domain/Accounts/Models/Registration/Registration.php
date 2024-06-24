<?php

namespace Domain\Accounts\Models\Registration;

use Domain\Accounts\Actions\Membership\Levels\LoadMembershipLevelByIdFromCache;
use Domain\Accounts\Enums\RegistrationRelations;
use Domain\Accounts\Enums\RegistrationStatus;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Accounts\QueryBuilders\RegistrationQueryBuilder;
use Domain\Orders\Models\Carts\Cart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Cache;
use Support\Traits\BelongsTo\BelongsToAccount;
use Support\Traits\BelongsTo\BelongsToAffiliate;
use Support\Traits\BelongsTo\BelongsToCart;
use Support\Traits\BelongsTo\BelongsToOrder;
use Support\Traits\BelongsTo\BelongsToPaymentMethod;
use Support\Traits\BelongsTo\BelongsToSite;
use Support\Traits\HasModelUtilities;

class Registration extends Model
{
    use HasFactory,
        HasModelUtilities,
        BelongsToSite,
        BelongsToAccount,
        BelongsToCart,
        BelongsToOrder,
        BelongsToAffiliate,
        BelongsToPaymentMethod;

    protected $fillable = [
        'account_id',
        'affiliate_id',
        'level_id',
        'payment_method_id',
        'site_id',
        'cart_id',
        'order_id',
        'status',
    ];

    protected $casts = [
        'status' => RegistrationStatus::class,
    ];

    public function usesTimestamps()
    {
        return true;
    }

    public function newEloquentBuilder($query): RegistrationQueryBuilder
    {
        return new RegistrationQueryBuilder($query);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleted(function (Registration $registration) {
            $registration->clearCaches();
        });

        static::updated(function (Registration $registration) {
            $registration->clearCaches();
        });
    }

    public function clearCaches()
    {
        Cache::tags([
            "registration-cache.{$this->id}",
        ])->flush();
    }

    public function relation(RegistrationRelations $relation)
    {
        return $this->loadMissingReturn($relation->value);
    }

//    public function discounts(): HasMany
//    {
//        return $this->HasMany(RegistrationDiscount::class);
//    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(MembershipLevel::class, 'level_id');
    }

    public function levelCached(): MembershipLevel
    {
        return $this->level ??= LoadMembershipLevelByIdFromCache::now($this->level_id);
    }

    public function levelWithProduct(): BelongsTo
    {
        return $this->level()->with('product');
    }

    public function levelWithProductCached(): MembershipLevel
    {
        $this->levelCached();
        $this->level->productCached();

        return $this->level;
    }

    public function levelWithProductPricing(): BelongsTo
    {
        return $this->level()->with('product.pricingForCurrentSite');
    }

    public function levelWithProductPricingCached(): MembershipLevel
    {
        $this->levelWithProductCached();

        $this->level->product->pricingBySiteCached($this->siteCached());

        return $this->level;
    }
}
