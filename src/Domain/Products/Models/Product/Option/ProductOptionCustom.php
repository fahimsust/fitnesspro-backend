<?php

namespace Domain\Products\Models\Product\Option;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class ProductsOptionsCustom
 *
 * @property int $value_id
 * @property bool $custom_type
 * @property int $custom_charlimit
 * @property string $custom_label
 * @property string $custom_instruction
 *
 * @property ProductOptionValue $products_options_value
 *
 * @package Domain\Products\Models\Product\Option
 */
class ProductOptionCustom extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'products_options_custom';

    protected $primaryKey = 'value_id';

    protected $casts = [
        'value_id' => 'int',
        'custom_type' => 'int',
        'custom_charlimit' => 'int',
    ];

    protected $fillable = [
        'custom_type',
        'custom_charlimit',
        'custom_label',
        'custom_instruction',
    ];

    public function optionValue()
    {
        return $this->belongsTo(ProductOptionValue::class, 'value_id');
    }
}
