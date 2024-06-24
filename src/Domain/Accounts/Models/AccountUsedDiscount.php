<?php

namespace Domain\Accounts\Models;

use Domain\Discounts\Models\Discount;
use Domain\Orders\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class AccountUsedDiscount extends Model
{
    use HasFactory,
        HasModelUtilities;

    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'accounts_discounts_used';

    protected $casts = [
        'account_id' => 'int',
        'discount_id' => 'int',
        'order_id' => 'int',
        'times_used' => 'int',
        'used' => 'datetime',
    ];

    protected $fillable = [
        'account_id',
        'discount_id',
        'order_id',
        'times_used',
        'used',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
