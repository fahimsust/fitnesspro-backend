<?php

namespace Domain\Orders\Models\Order;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OrdersTask
 *
 * @property int $id
 * @property int $order_id
 * @property string $message
 * @property bool $priority
 *
 * @property Order $order
 *
 * @package Domain\Orders\Models
 */
class OrderTask extends Model
{
    public $timestamps = false;
    protected $table = 'orders_tasks';

    protected $casts = [
        'order_id' => 'int',
        'priority' => 'bool',
    ];

    protected $fillable = [
        'order_id',
        'message',
        'priority',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
