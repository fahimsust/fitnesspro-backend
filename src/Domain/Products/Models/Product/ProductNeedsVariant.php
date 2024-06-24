<?php

namespace Domain\Products\Models\Product;

use Domain\Products\Models\Product\Option\ProductOption;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductsNeedschild
 *
 * @property int $product_id
 * @property int $option_id
 * @property int $qty
 * @property string $account_level
 *
 * @property ProductOption $products_option
 * @property Product $product
 *
 * @package Domain\Products\Models\Product
 */
class ProductNeedsVariant extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'products_needschildren';

    protected $casts = [
        'product_id' => 'int',
        'option_id' => 'int',
        'qty' => 'int',
    ];

    protected $fillable = [
        'product_id',
        'option_id',
        'qty',
        'account_level',
    ];

    public function option()
    {
        return $this->belongsTo(ProductOption::class, 'option_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
