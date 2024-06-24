<?php

namespace Domain\Affiliates\Models;

use Domain\Accounts\Models\AccountType;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Traits\HasModelUtilities;

/**
 * Class AffiliatesLevel
 *
 * @property int $id
 * @property string $name
 * @property float $order_rate
 * @property float $subscription_rate
 *
 * @property Collection|array<MembershipLevel> $accounts_membership_levels
 * @property Collection|array<AccountType> $accounts_types
 * @property Collection|array<Affiliate> $affiliates
 *
 * @package Domain\Affiliates\Models
 */
class AffiliateLevel extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $casts = [
        'points' => 'array',
    ];

    protected $fillable = [
        'name',
        'points',
    ];

    public function membershipLevels(): HasMany
    {
        return $this->hasMany(MembershipLevel::class, 'affiliate_level_id');
    }

    public function accountTypes(): HasMany
    {
        return $this->hasMany(AccountType::class, 'affiliate_level_id');
    }

    public function affiliates(): HasMany
    {
        return $this->hasMany(Affiliate::class, 'affiliate_level_id');
    }

    public function referralPointsForOrder(): int
    {
        return $this->points['order'] ?? 0;
    }

    public function referralPointsForSubscription(
        MembershipLevel $membershipLevel,
    ): int
    {
        if(!array_key_exists($membershipLevel->tag, $this->points['subscription'])) {
            return 0;
        }

        return $this->points['subscription'][$membershipLevel->tag];
    }
}
