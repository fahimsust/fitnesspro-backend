<?php

namespace Domain\Accounts\Models\LoyaltyPoints;

use Domain\Accounts\Models\Account;
use Illuminate\Database\Eloquent\Model;

class AvailablePoints extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'accounts_loyaltypoints';

    protected $casts = [
        'account_id' => 'int',
        'loyaltypoints_level_id' => 'int',
        'points_available' => 'int',
    ];

    protected $fillable = [
        'points_available',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function loyaltyLevel()
    {
        return $this->belongsTo(LoyaltyProgramLevel::class);
    }
}
