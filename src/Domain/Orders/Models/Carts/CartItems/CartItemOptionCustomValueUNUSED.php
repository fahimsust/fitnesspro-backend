<?php

namespace Domain\Orders\Models\Carts\CartItems;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class CartItemOptionCustomValueUNUSED extends Model
{
    use HasFactory, HasModelUtilities;
    public $incrementing = false;

    protected $table = 'cart_item_option_customvalues';

    protected $primaryKey = 'item_option_id';

    protected $casts = [
        'item_option_id' => 'int',
        'custom_value' => 'string',
    ];

    public function itemOption()
    {
        return $this->belongsTo(CartItemOption::class);
    }
}
