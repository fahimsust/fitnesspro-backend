<?php

namespace Domain\Products\Models\Product;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductsViewed
 *
 * @property int $product_id
 * @property Carbon $viewed
 *
 * @property Product $product
 *
 * @package Domain\Products\Models\Product
 */
class ProductView extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'products_viewed';

    protected $casts = [
        'product_id' => 'int',
        'viewed' => 'datetime',
    ];

    protected $fillable = [
        'product_id',
        'viewed',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
