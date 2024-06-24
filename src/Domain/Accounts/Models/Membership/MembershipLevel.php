<?php

namespace Domain\Accounts\Models\Membership;

use Domain\Accounts\Models\AccountType;
use Domain\Accounts\QueryBuilders\MemberShipLevelQuery;
use Domain\Affiliates\Models\AffiliateLevel;
use Domain\Discounts\Models\Rule\Condition\ConditionMembershipLevel;
use Domain\Products\Actions\Product\LoadProductByIdFromCache;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Cache;
use Support\Traits\HasModelUtilities;

class MembershipLevel extends Model
{
    use HasFactory,
        HasModelUtilities;

    public $timestamps = false;

    protected $table = 'membership_levels';

    protected $casts = [
        'rank' => 'int',
        'status' => 'bool',
        'annual_product_id' => 'int',
        'monthly_product_id' => 'int',
        'renewal_discount' => 'float',
        'signupemail_customer' => 'int',
        'renewemail_customer' => 'int',
        'expirationalert1_email' => 'int',
        'expirationalert2_email' => 'int',
        'expiration_email' => 'int',
        'affiliate_level_id' => 'int',
        'is_default' => 'bool',
        'signuprenew_option' => 'bool',
        'trial' => 'bool',
        'auto_renewal_of' => 'int',
        'auto_renew_reward' => 'int',
    ];

    protected $fillable = [
        'name',
        'rank',
        'status',
        'annual_product_id',
        'monthly_product_id',//TODO drop monthly_product_id
        'renewal_discount',
        'description',
        'signupemail_customer',
        'renewemail_customer',
        'expirationalert1_email',
        'expirationalert2_email',
        'expiration_email',
        'affiliate_level_id',
        'is_default',
        'signuprenew_option',
        'trial',
        'auto_renewal_of',
        'auto_renew_reward',
        'tag',
    ];

    public function newEloquentBuilder($query)
    {
        return new MemberShipLevelQuery($query);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleted(function (MembershipLevel $level) {
            $level->clearCaches();
        });

        static::updated(function (MembershipLevel $level) {
            $level->clearCaches();
        });
    }

    public function clearCaches(): void
    {
        Cache::tags([
            "membership-level-cache.{$this->id}"
        ])->flush();
    }

    public function affiliateLevel(): BelongsTo
    {
        return $this->belongsTo(AffiliateLevel::class, 'affiliate_level_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(
            Product::class,
            'annual_product_id'
        );
    }

    public function productCached(): Product
    {
        return LoadProductByIdFromCache::now($this->annual_product_id);
    }

    public function attributes()
    {
        //TODO test
        return $this->hasManyThrough(
            MembershipAttribute::class,
            MembershipLevelAttribute::class,
            'level_id',
            'attribute_id'
        );
    }

    public function settings(): HasOne
    {
        return $this->hasOne(MembershipLevelSetting::class, 'level_id');
    }

    public function memberships(): HasMany
    {
        return $this->hasMany(Subscription::class, 'level_id');
    }

    public function accountType(): HasOne
    {
        return $this->hasOne(AccountType::class, 'membership_level_id');
    }

    public function discountConditions(): HasMany
    {
        return $this->hasMany(
            ConditionMembershipLevel::class,
            'membershiplevel_id'
        );
    }
}
