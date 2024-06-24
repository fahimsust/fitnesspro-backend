<?php

namespace Domain\Products\Models\Product;

use Carbon\Carbon;
use Domain\Distributors\Models\Distributor;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductsLog
 *
 * @property int $product_id
 * @property int $id
 * @property int $productdistributor_id
 * @property int $action_type
 * @property string $changed_from
 * @property string $changed_to
 * @property Carbon $logged
 *
 * @property Product $product
 * @property ProductDistributor $products_distributor
 *
 * @package Domain\Products\Models\Product
 */
class ProductLog extends Model
{
    public $timestamps = false;
    protected $table = 'products_log';

    protected $casts = [
        'product_id' => 'int',
        'productdistributor_id' => 'int',
        'action_type' => 'int',
        'logged' => 'datetime',
    ];

    protected $fillable = [
        'product_id',
        'productdistributor_id',
        'action_type',
        'changed_from',
        'changed_to',
        'logged',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function distributorProduct()
    {
        return $this->belongsTo(ProductDistributor::class, 'productdistributor_id');
    }

    public function distributor()
    {
        return $this->hasOneThrough(
            Distributor::class,
            ProductDistributor::class,
            'productdistributor_id'
        );
    }
}
