<?php

namespace Domain\Orders\Models\Order\Transactions;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OrdersTransactionsStatus
 *
 * @property int $id
 * @property string $name
 *
 * @package Domain\Orders\Models
 */
class OrderTransactionStatus extends Model
{
    public $timestamps = false;
    protected $table = 'orders_transactions_statuses';

    protected $fillable = [
        'name',
    ];
}
