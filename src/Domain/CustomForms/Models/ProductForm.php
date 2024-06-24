<?php

namespace Domain\CustomForms\Models;

use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class CustomFormsShowProduct
 *
 * @property int $form_id
 * @property int $product_id
 * @property int $rank
 *
 * @property CustomForm $custom_form
 * @property Product $product
 *
 * @package Domain\CustomForms\Models
 */
class ProductForm extends Model
{
    use HasFactory,
        HasModelUtilities;

    public $incrementing = false;

    protected $table = 'custom_forms_show_products';

    protected $casts = [
        'form_id' => 'int',
        'product_id' => 'int',
        'rank' => 'int',
    ];

    public function form()
    {
        return $this->belongsTo(CustomForm::class, 'form_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
