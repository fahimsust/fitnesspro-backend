<?php

namespace Domain\Orders\Models\Order;

use Carbon\Carbon;
use Domain\CustomForms\Models\CustomForm;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class OrdersCustomform
 *
 * @property int $id
 * @property int $order_id
 * @property int $form_id
 * @property int $product_id
 * @property int $product_type_id
 * @property int $form_count
 * @property string $form_values
 * @property Carbon $created
 * @property Carbon $modified
 *
 * @property CustomForm $custom_form
 * @property Order $order
 * @property Product $product
 * @property ProductType $products_type
 *
 * @package Domain\Orders\Models
 */
class OrderCustomForm extends Model
{
    use HasFactory,
        HasModelUtilities;

    public const CREATED_AT = 'created';
    public const UPDATED_AT = 'modified';
    protected $table = 'orders_customforms';

    protected $casts = [
        'order_id' => 'int',
        'form_id' => 'int',
        'product_id' => 'int',
        'product_type_id' => 'int',
        'form_count' => 'int',
        'created' => 'datetime',
        'modified' => 'datetime',
        'form_values' => 'json',
    ];

    public function usesTimestamps()
    {
        return true;
    }

    public function form()
    {
        return $this->belongsTo(CustomForm::class, 'form_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }
}
