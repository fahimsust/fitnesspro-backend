<?php

namespace Domain\Affiliates\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AffiliatesPayment
 *
 * @property int $id
 * @property int $affiliate_id
 * @property float $amount
 * @property string $notes
 * @property Carbon $created
 *
 * @property Affiliate $affiliate
 * @property PayoutReferral $affiliates_payments_referral
 *
 * @package Domain\Affiliates\Models
 */
class Payout extends Model
{
    public $timestamps = false;
    protected $table = 'affiliates_payments';

    protected $casts = [
        'affiliate_id' => 'int',
        'amount' => 'float',
        'created' => 'datetime',
    ];

    protected $fillable = [
        'affiliate_id',
        'amount',
        'notes',
        'created',
    ];

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function referrals()
    {
        return $this->hasMany(PayoutReferral::class, 'payment_id');
    }
}
