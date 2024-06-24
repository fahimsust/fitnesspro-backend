<?php

namespace Domain\Products\Models\Product\Specialties;

use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductsSpecialtiesCheck
 *
 * @property int $product_id
 * @property string $specialties
 *
 * @property Product $product
 *
 * @package Domain\Products\Models\Product
 */
class ProductSpecialtiesCheck extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'products_specialties_check';

    protected $casts = [
        'product_id' => 'int',
    ];

    protected $fillable = [
        'product_id',
        'specialties',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
