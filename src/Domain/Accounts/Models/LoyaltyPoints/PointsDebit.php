<?php

namespace Domain\Accounts\Models\LoyaltyPoints;

use Domain\Accounts\Models\Account;
use Domain\Orders\Models\Order\Order;
use Illuminate\Database\Eloquent\Model;

class PointsDebit extends Model
{
    public $timestamps = false;
    protected $table = 'accounts_loyaltypoints_debits';

    protected $casts = [
        'account_id' => 'int',
        'loyaltypoints_level_id' => 'int',
        'order_id' => 'int',
        'points_used' => 'int',
        'created' => 'datetime',
    ];

    protected $fillable = [
        'account_id',
        'loyaltypoints_level_id',
        'order_id',
        'points_used',
        'created',
        'notes',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function loyaltyLevel()
    {
        return $this->belongsTo(LoyaltyProgramLevel::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
