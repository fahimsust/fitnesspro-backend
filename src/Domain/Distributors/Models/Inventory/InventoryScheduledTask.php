<?php

namespace Domain\Distributors\Models\Inventory;

use Carbon\Carbon;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InventoryGatewaysScheduledtask
 *
 * @property int $id
 * @property int $gateway_account_id
 * @property int $task_type
 * @property int $task_start
 * @property Carbon $task_startdate
 * @property bool $task_status
 * @property int $task_modified
 * @property string $task_custom_info
 *
 * @property InventoryAccount $inventory_gateways_account
 * @property Collection|array<Product> $products
 *
 * @package Domain\Distributors\Models\Inventory
 */
class InventoryScheduledTask extends Model
{
    public $timestamps = false;
    protected $table = 'inventory_gateways_scheduledtasks';

    protected $casts = [
        'gateway_account_id' => 'int',
        'task_type' => 'int',
        'task_start' => 'int',
        'task_status' => 'bool',
        'task_modified' => 'int',
        'task_startdate' => 'datetime',
    ];

    protected $fillable = [
        'gateway_account_id',
        'task_type',
        'task_start',
        'task_startdate',
        'task_status',
        'task_modified',
        'task_custom_info',
    ];

    public function inventoryAccount()
    {
        return $this->belongsTo(
            InventoryAccount::class,
            'gateway_account_id'
        );
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'inventory_gateways_scheduledtasks_products', 'task_id', 'products_id')
            ->withPivot('id', 'products_distributors_id', 'created');
    }
}
