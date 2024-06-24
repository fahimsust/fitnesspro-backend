<?php

namespace Domain\Distributors\Models\Inventory;

use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InventoryGatewaysSite
 *
 * @property int $id
 * @property int $gateway_account_id
 * @property int $site_id
 * @property bool $update_pricing
 * @property float $pricing_adjustment
 * @property bool $update_status
 * @property bool $publish_on_import
 * @property string $regular_price_field
 * @property string $sale_price_field
 * @property bool $onsale_formula
 *
 * @property InventoryAccount $inventory_gateways_account
 * @property Site $site
 *
 * @package Domain\Distributors\Models\Inventory
 */
class InventoryGatewaySite extends Model
{
    public $timestamps = false;
    protected $table = 'inventory_gateways_sites';

    protected $casts = [
        'gateway_account_id' => 'int',
        'site_id' => 'int',
        'update_pricing' => 'bool',
        'pricing_adjustment' => 'float',
        'update_status' => 'bool',
        'publish_on_import' => 'bool',
        'onsale_formula' => 'bool',
    ];

    protected $fillable = [
        'gateway_account_id',
        'site_id',
        'update_pricing',
        'pricing_adjustment',
        'update_status',
        'publish_on_import',
        'regular_price_field',
        'sale_price_field',
        'onsale_formula',
    ];

    public function inventoryAccount()
    {
        return $this->belongsTo(InventoryAccount::class, 'gateway_account_id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
