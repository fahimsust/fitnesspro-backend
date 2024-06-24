<?php

namespace Domain\Accounts\Models\Membership;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Domain\Orders\Models\Order\Order;
use Domain\Payments\Models\PaymentMethod;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\HasModelUtilities;

class Subscription extends Model
{
    use HasFactory,
        HasModelUtilities;

    public const CREATED_AT = 'created';
    public const UPDATED_AT = null;

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'cancelled' => 'datetime',
        'auto_renew' => 'boolean',
        'renew_payment_method' => 'int',
        'renew_payment_profile_id' => 'int',
    ];

//    protected $appends = ['account', 'order', 'product'];
    protected $table = 'membership_subscriptions';

    public function usesTimestamps()
    {
        return true;
    }

    public function subscriber()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function level()
    {
        return $this->belongsTo(MembershipLevel::class, 'level_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function daysUntilExpiration(): int
    {
        return $this->end_date->diffInDays(Carbon::now());
    }

    public function renewPaymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'renew_payment_method');
    }
}
