<?php

namespace Domain\Affiliates\Models;

use Domain\Affiliates\Enums\ReferralType;
use Domain\Affiliates\QueryBuilders\ReferralQuery;
use Domain\Orders\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Support\Traits\HasModelUtilities;

class Referral extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'affiliates_referrals';
    protected $appends = ['type_label'];

    protected $casts = array(
        'affiliate_id' => 'int',
        'order_id' => 'int',
        'status_id' => 'int',
        'amount' => 'float',
        'type_id' => ReferralType::class,
    );

    public function getTypeLabelAttribute(): string
    {
        return ReferralType::from($this->attributes['type_id'])
            ->label();
    }

    public function newEloquentBuilder($query)
    {
        return new ReferralQuery($query);
    }

    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(ReferralStatus::class, 'status_id');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(PayoutReferral::class, 'referral_id');
    }
}
