<?php

namespace Domain\Affiliates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class ReferralStatus extends Model
{
    use HasFactory,
        HasModelUtilities;

    public $timestamps = false;

    protected $table = 'affiliates_referrals_statuses';

    protected $fillable = [
        'name',
    ];

    public function referrals()
    {
        return $this->hasMany(Referral::class, 'status_id');
    }
}
