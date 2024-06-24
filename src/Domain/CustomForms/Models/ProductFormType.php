<?php

namespace Domain\CustomForms\Models;

use Domain\Products\Models\Product\ProductType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class CustomFormsShowProducttype
 *
 * @property int $form_id
 * @property int $product_type_id
 *
 * @property CustomForm $custom_form
 * @property ProductType $products_type
 *
 * @package Domain\CustomForms\Models
 */
class ProductFormType extends Model
{
    use HasFactory,HasModelUtilities;
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'custom_forms_show_producttypes';

    protected $casts = [
        'form_id' => 'int',
        'product_type_id' => 'int',
    ];

    protected $fillable = [
        'form_id',
        'product_type_id',
    ];

    public function form()
    {
        return $this->belongsTo(CustomForm::class, 'form_id');
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }
}
