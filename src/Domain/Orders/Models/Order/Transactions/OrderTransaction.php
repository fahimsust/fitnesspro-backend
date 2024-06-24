<?php

namespace Domain\Orders\Models\Order\Transactions;

use Domain\Accounts\Models\Cim\CimPaymentProfile;
use Domain\Addresses\Models\Address;
use Domain\Orders\Enums\Order\OrderTransactionStatuses;
use Domain\Orders\Models\Order\Order;
use Domain\Payments\Actions\LoadPaymentAccountByIdFromCache;
use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Support\Traits\BelongsTo\BelongsToOrder;
use Support\Traits\BelongsTo\BelongsToPaymentAccount;
use Support\Traits\BelongsTo\BelongsToPaymentMethod;
use Support\Traits\ClearsCache;
use Support\Traits\HasModelUtilities;

class OrderTransaction extends Model
{
    use HasModelUtilities,
        HasFactory,
        ClearsCache,
        SoftDeletes,
        BelongsToPaymentAccount,
        BelongsToPaymentMethod,
        BelongsToOrder,
        MassPrunable;

    public $timestamps = false;

    protected $table = 'orders_transactions';

    protected $casts = [
        'order_id' => 'int',
        'amount' => 'float',
        'original_amount' => 'float',
        'status' => OrderTransactionStatuses::class,
        'billing_address_id' => 'int',
        'payment_method_id' => 'int',
        'gateway_account_id' => 'int',
        'cim_payment_profile_id' => 'int',
        'capture_on_shipment' => 'int',
        'cc_exp' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'voided_at' => 'datetime',
        'data' => 'array',
    ];

    protected $fillable = [
        'order_id',
        'transaction_no',
        'amount',
        'original_amount',
        'cc_no',
        'cc_exp',
        'notes',
        'status',
        'billing_address_id',
        'payment_method_id',
        'gateway_account_id',
        'created_at',
        'updated_at',
        'cim_payment_profile_id',
        'capture_on_shipment',
        'voided_at',
        'data'
    ];

    public function prunable(): Builder
    {
        return static::where('deleted_at', '<=', now()->subMonth());
    }

    protected function cacheTags(): array
    {
        return [
            "order-transaction-cache.{$this->id}",
            "order-transactions-cache.{$this->order_id}",
        ];
    }

    public function billingAddress()
    {
        return $this->belongsTo(
            Address::class,
            'billing_address_id'
        );
    }

    public function cimPaymentProfile()
    {
        return $this->belongsTo(
            CimPaymentProfile::class,
            'cim_payment_profile_id'
        );
    }

    public function refunds(): HasMany
    {
        return $this->hasMany(
            OrderTransactionRefund::class,
            'orders_transactions_id'
        );
    }
}
