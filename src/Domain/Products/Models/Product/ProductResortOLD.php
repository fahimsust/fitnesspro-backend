<?php

namespace Domain\Products\Models\Product;

use Domain\Resorts\Models\Resort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class ProductsResort
 *
 * @property int $product_id
 * @property int $resort_id
 *
 * @property Product $product
 * @property Resort $resort
 *
 * @package Domain\Products\Models\Product
 */
class ProductResortOLD extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'products_resort';

    protected $primaryKey = 'product_id';

    protected $casts = [
        'product_id' => 'int',
        'resort_id' => 'int',
    ];

    protected $fillable = [
        'resort_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function resort()
    {
        return $this->belongsTo(Resort::class);
    }
}
