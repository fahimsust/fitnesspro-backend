<?php

namespace Domain\Orders\Models\Order\OrderItems;

use Domain\Messaging\Models\MessageTemplate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class OrderItemSentEmail extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'orders_products_sentemails';

    protected $casts = [
        'orders_products_id' => 'int',
        'email_id' => 'int',
    ];

    protected $fillable = [
        'orders_products_id',
        'email_id',
    ];

    public function messageTemplate()
    {
        return $this->belongsTo(
            MessageTemplate::class,
            'email_id'
        );
    }

    public function orderProduct()
    {
        return $this->belongsTo(
            OrderItem::class,
            'orders_products_id'
        );
    }
}
