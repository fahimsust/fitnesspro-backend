<?php

namespace Domain\Affiliates\Models;

use Domain\Accounts\Models\Account;
use Domain\Addresses\Models\Address;
use Domain\Addresses\Traits\BelongsToAddress;
use Domain\Affiliates\QueryBuilders\AffiliateQuery;
use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\BelongsTo\BelongsToAccount;
use Support\Traits\ClearsCache;
use Support\Traits\HasModelUtilities;

/**
 * Class Affiliate
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string $address_1
 * @property string $address_2
 * @property string $city
 * @property int $state_id
 * @property int $country_id
 * @property string $postal_code
 * @property bool $status
 * @property int $affiliate_level_id
 * @property int $account_id
 *
 * @property Account $account
 * @property AffiliateLevel $affiliates_level
 * @property Country $country
 * @property StateProvince $state
 * @property Collection|array<Account> $accounts
 * @property Collection|array<Payout> $affiliates_payments
 * @property Collection|array<Referral> $affiliates_referrals
 *
 * @package Domain\Affiliates\Models
 */
class Affiliate extends Model
{
    use HasFactory,
        HasModelUtilities,
        BelongsToAddress,
        BelongsToAccount,
        ClearsCache;

    public $timestamps = false;

    protected $casts = [
        'status' => 'bool',
        'affiliate_level_id' => 'int',
        'account_id' => 'int',
    ];

    protected $hidden = [
        'password',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'affiliate_level_id',
        'account_id',
        'address_id',
    ];

    protected function cacheTags(): array
    {
        return [
            "affiliate-cache.{$this->id}"
        ];
    }

    public function newEloquentBuilder($query)
    {
        return new AffiliateQuery($query);
    }

    public function level()
    {
        return $this->belongsTo(AffiliateLevel::class, 'affiliate_level_id');
    }

    public function payments()
    {
        return $this->hasMany(Payout::class);
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class);
    }
}
