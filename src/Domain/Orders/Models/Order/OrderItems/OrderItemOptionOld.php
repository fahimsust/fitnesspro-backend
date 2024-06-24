<?php

namespace Domain\Orders\Models\Order\OrderItems;

use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class OrderItemOptionOld extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'orders_products_options';

    protected $casts = [
        'orders_products_id' => 'int',
        'value_id' => 'int',
        'price' => 'int',
    ];

    protected $fillable = [
        'orders_products_id',
        'value_id',
        'price',
        'custom_value',
    ];

    public function item()
    {
        return $this->belongsTo(
            OrderItem::class,
            'orders_products_id'
        );
    }

    public function optionValue()
    {
        return $this->belongsTo(
            ProductOptionValue::class,
            'value_id'
        );
    }

    public function option()
    {
        //todo
        return $this->hasOneThrough(
            ProductOption::class,
            ProductOptionValue::class,
        );
    }
}
