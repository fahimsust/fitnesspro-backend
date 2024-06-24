<?php

namespace Domain\Products\Models\Product;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductsTask
 *
 * @property int $id
 * @property int $product_id
 * @property string $message
 * @property bool $priority
 *
 * @property Product $product
 *
 * @package Domain\Products\Models\Product
 */
class ProductTask extends Model
{
    public $timestamps = false;
    protected $table = 'products_tasks';

    protected $casts = [
        'product_id' => 'int',
        'priority' => 'bool',
    ];

    protected $fillable = [
        'product_id',
        'message',
        'priority',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
