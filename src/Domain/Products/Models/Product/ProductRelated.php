<?php

namespace Domain\Products\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class ProductsRelated
 *
 * @property int $product_id
 * @property int $related_id
 *
 * @property Product $product
 *
 * @package Domain\Products\Models\Product
 */
class ProductRelated extends Model
{
    use HasFactory,
        HasModelUtilities;
    use HasFactory,
        HasModelUtilities;

    protected $table = 'products_related';

    protected $casts = [
        'product_id' => 'int',
        'related_id' => 'int',
    ];

    public function product()
    {
        return $this->belongsTo(
            Product::class,
            'product_id'
        );
    }

    public function related()
    {
        return $this->belongsTo(
            Product::class,
            'related_id'
        );
    }
}
