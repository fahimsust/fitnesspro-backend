<?php

namespace Domain\Distributors\Models\Inventory;

use Domain\Distributors\Models\Distributor;
use Domain\Locales\Models\Currency;
use Domain\Orders\Models\Order\Order;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class InventoryAccount extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $timestamps = false;

    protected $table = 'inventory_gateways_accounts';

    protected $casts = [
        'gateway_id' => 'int',
        'last_load_id' => 'int',
        'frequency_load' => 'bool',
        'frequency_update' => 'bool',
        'update_pricing' => 'bool',
        'update_status' => 'bool',
        'update_cost' => 'bool',
        'update_weight' => 'bool',
        'create_children' => 'bool',
        'onsale_formula' => 'bool',
        'use_taxinclusive_pricing' => 'bool',
        'status' => 'bool',
        'use_parent_inventory_id' => 'bool',
        'distributor_id' => 'int',
        'base_currency' => 'int',
        'last_load' => 'datetime',
        'last_update' => 'datetime',
        'last_price_sync' => 'datetime',
        'last_matrix_price_sync' => 'datetime',
    ];

    protected $hidden = [
        'password',
        'refresh_token',
    ];

    protected $fillable = [
        'gateway_id',
        'name',
        'user',
        'password',
        'url',
        'transkey',
        'last_load',
        'last_load_id',
        'last_update',
        'frequency_load',
        'frequency_update',
        'last_price_sync',
        'last_matrix_price_sync',
        'update_pricing',
        'update_status',
        'update_cost',
        'update_weight',
        'create_children',
        'regular_price_field',
        'sale_price_field',
        'onsale_formula',
        'use_taxinclusive_pricing',
        'custom_fields',
        'timezone',
        'payment_method',
        'status',
        'refresh_token',
        'use_parent_inventory_id',
        'distributor_id',
        'base_currency',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'base_currency');
    }

    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

    public function paymentGateway()
    {
        return $this->belongsTo(InventoryGateway::class, 'gateway_id');
    }

    public function usedByOrders()
    {
        //todo
        return $this->hasManyThrough(
            Order::class,
            GatewayOrder::class,
            'gateway_account_id'
        );
    }

    public function scheduledTasks()
    {
        return $this->hasMany(
            InventoryScheduledTask::class,
            'gateway_account_id'
        );
    }

    public function sites()
    {
        //todo
        return $this->hasManyThrough(
            Site::class,
            InventoryGatewaySite::class,
            'gateway_account_id'
        );
    }
}
