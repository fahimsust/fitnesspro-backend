<?php

namespace Domain\Products\Models\BulkEdit;

use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BulkeditChangeProduct
 *
 * @property int $change_id
 * @property int $product_id
 * @property string $changed_from
 *
 * @property BulkEditActivity $bulkedit_change
 * @property Product $product
 *
 * @package Domain\Products\Models
 */
class BulkEditActivityProduct extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'bulkedit_change_products';

    protected $casts = [
        'change_id' => 'int',
        'product_id' => 'int',
    ];

    protected $fillable = [
        'changed_from',
    ];

    public function activity()
    {
        return $this->belongsTo(BulkEditActivity::class, 'change_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
