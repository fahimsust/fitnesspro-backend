<?php

namespace Domain\Affiliates\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AffiliatesPaymentsReferral
 *
 * @property int $payment_id
 * @property int $referral_id
 *
 * @property Payout $affiliates_payment
 * @property Referral $affiliates_referral
 *
 * @package Domain\Affiliates\Models
 */
class PayoutReferral extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'affiliates_payments_referrals';

    protected $casts = [
        'payment_id' => 'int',
        'referral_id' => 'int',
    ];

    protected $fillable = [
        'payment_id',
        'referral_id',
    ];

    public function payout()
    {
        return $this->belongsTo(Payout::class, 'payment_id');
    }

    public function referral()
    {
        return $this->belongsTo(Referral::class, 'referral_id');
    }
}
