<?php

namespace Domain\Distributors\Models\Inventory;

use Carbon\Carbon;
use Domain\Distributors\Models\Distributor;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDistributor;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InventoryGatewaysScheduledtasksProduct
 *
 * @property int $id
 * @property int $task_id
 * @property int $products_id
 * @property int $products_distributors_id
 * @property Carbon $created
 *
 * @property Product $product
 * @property InventoryScheduledTask $inventory_gateways_scheduledtask
 * @property Distributor $distributor
 *
 * @package Domain\Distributors\Models\Inventory
 */
class InventoryScheduledTaskProduct extends Model
{
    public $timestamps = false;
    protected $table = 'inventory_gateways_scheduledtasks_products';

    protected $casts = [
        'task_id' => 'int',
        'products_id' => 'int',
        'products_distributors_id' => 'int',
        'created' => 'datetime',
    ];

    protected $fillable = [
        'task_id',
        'products_id',
        'products_distributors_id',
        'created',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }

    public function scheduledTask()
    {
        return $this->belongsTo(InventoryScheduledTask::class, 'task_id');
    }

    public function distributor()
    {
        //todo
        return $this->hasOneThrough(
            Distributor::class,
            ProductDistributor::class,
            'products_distributors_id'
        );
    }
}
