<?php

namespace Domain\Products\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class ProductsAccessory
 *
 * @property int $product_id
 * @property int $accessory_id
 * @property bool $required
 * @property bool $show_as_option
 * @property int $discount_percentage
 * @property string $description
 * @property bool $link_actions
 *
 * @property Product $product
 *
 * @package Domain\Products\Models\Product
 */
class ProductAccessory extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $incrementing = false;

    protected $table = 'products_accessories';

    protected $casts = [
        'product_id' => 'int',
        'accessory_id' => 'int',
        'required' => 'bool',
        'show_as_option' => 'bool',
        'discount_percentage' => 'int',
        'link_actions' => 'bool',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function accessory()
    {
        return $this->belongsTo(
            Product::class,
            'accessory_id'
        );
    }
}
