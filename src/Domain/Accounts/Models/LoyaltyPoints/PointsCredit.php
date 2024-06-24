<?php

namespace Domain\Accounts\Models\LoyaltyPoints;

use Domain\Accounts\Models\Account;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Illuminate\Database\Eloquent\Model;

class PointsCredit extends Model
{
    public $timestamps = false;
    protected $table = 'accounts_loyaltypoints_credits';

    protected $casts = [
        'account_id' => 'int',
        'loyaltypoints_level_id' => 'int',
        'shipment_id' => 'int',
        'points_awarded' => 'int',
        'status' => 'bool',
        'created' => 'datetime',
    ];

    protected $fillable = [
        'account_id',
        'loyaltypoints_level_id',
        'shipment_id',
        'points_awarded',
        'status',
        'created',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function loyaltyLevel()
    {
        return $this->belongsTo(LoyaltyProgramLevel::class);
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id');
    }
}
