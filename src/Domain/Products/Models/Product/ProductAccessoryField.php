<?php

namespace Domain\Products\Models\Product;

use Domain\Products\Models\Product\AccessoryField\AccessoryField;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class ProductsAccessoriesField
 *
 * @property int $product_id
 * @property int $accessories_fields_id
 * @property int $rank
 *
 * @property AccessoryField $accessories_field
 * @property Product $product
 *
 * @package Domain\Products\Models\Product
 */
class ProductAccessoryField extends Model
{
    use HasFactory,
        HasModelUtilities;

    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'products_accessories_fields';

    protected $casts = [
        'product_id' => 'int',
        'accessories_fields_id' => 'int',
        'rank' => 'int',
    ];

    protected $fillable = [
        'product_id',
        'accessories_fields_id',
        'rank',
    ];

    public function accessoryField()
    {
        return $this->belongsTo(AccessoryField::class, 'accessories_fields_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
