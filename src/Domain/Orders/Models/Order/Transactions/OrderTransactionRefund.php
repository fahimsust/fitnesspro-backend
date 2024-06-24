<?php

namespace Domain\Orders\Models\Order\Transactions;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class OrdersTransactionsCredit
 *
 * @property int $id
 * @property int $orders_transactions_id
 * @property float $amount
 * @property Carbon $recorded
 * @property string $transaction_id
 *
 * @property OrderTransaction $orders_transaction
 *
 * @package Domain\Orders\Models
 */
class OrderTransactionRefund extends Model
{
    use HasModelUtilities;
    protected $table = 'orders_transactions_credits';

    protected $casts = [
        'orders_transactions_id' => 'int',
        'amount' => 'int',
        'recorded' => 'datetime',
    ];

    protected $fillable = [
        'orders_transactions_id',
        'amount',
        'recorded',
        'transaction_id',
    ];

    public function transaction()
    {
        return $this->belongsTo(
            OrderTransaction::class,
            'orders_transactions_id'
        );
    }
}
