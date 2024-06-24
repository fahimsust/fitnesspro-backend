<?php

namespace Domain\Distributors\Models;

use Domain\AdminUsers\Models\AdminUser;
use Domain\AdminUsers\Models\AdminUserDistributor;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Distributors\Models\Inventory\InventoryAccount;
use Domain\Distributors\Models\Inventory\InventoryScheduledTaskProduct;
use Domain\Distributors\Models\Shipping\DistributorShippingGateway;
use Domain\Distributors\Models\Shipping\DistributorShippingMethod;
use Domain\Distributors\QueryBuilders\DistributorQuery;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Domain\Orders\Models\Shipping\ShippingGateway;
use Domain\Orders\Models\Shipping\ShippingMethod;
use Domain\Products\Models\FulfillmentRules\FulfillmentRule;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDistributor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Support\Traits\HasModelUtilities;

class Distributor extends Model
{
    use HasFactory,
        HasModelUtilities;

    public $timestamps = false;

    protected $table = 'distributors';

    protected $casts = [
        'active' => 'bool',
        'is_dropshipper' => 'bool',
        'inventory_account_id' => 'int',
    ];

    protected $fillable = [
        'name',
        'active',
        'email',
        'phone',
        'account_no',
        'is_dropshipper',
        'inventory_account_id',
    ];

    public function newEloquentBuilder($query)
    {
        return new DistributorQuery($query);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::deleted(function (Distributor $distributor) {
            $distributor->clearCaches();
        });

        static::updated(function (Distributor $distributor) {
            $distributor->clearCaches();
        });
    }

    public function clearCaches(): void
    {
        Cache::tags([
            'distributor-id-cache.' . $this->id,
        ])->flush();
    }

    public function adminUsers()
    {
        //todo
        return $this->hasManyThrough(
            AdminUser::class,
            AdminUserDistributor::class,
            'distributor_id',
            'user_id'
        );
    }

    public function discountConditions()
    {
        return $this->belongsToMany(DiscountCondition::class, 'discount_rule_condition_distributors', 'distributor_id', 'condition_id');
    }

    public function availabilities()
    {
        return $this->hasMany(DistributorAvailability::class);
    }
    //
    //    public function distributors_canadapost()
    //    {
    //        return $this->hasOne(DistributorsCanadapost::class);
    //    }
    //
    //    public function distributors_endicium()
    //    {
    //        return $this->hasOne(DistributorsEndicium::class);
    //    }
    //
    //    public function distributors_fedex()
    //    {
    //        return $this->hasOne(DistributorsFedex::class);
    //    }
    //
    //    public function distributors_genericshipping()
    //    {
    //        return $this->hasOne(DistributorsGenericshipping::class);
    //    }

    public function shippingGateways()
    {
        //todo
        return $this->hasManyThrough(
            ShippingGateway::class,
            DistributorShippingGateway::class,
        )
            ->withPivot('id');
    }

    public function shippingMethods()
    {
        //todo
        return $this->hasManyThrough(
            ShippingMethod::class,
            DistributorShippingMethod::class,
        )
            ->withPivot('id', 'status', 'flat_price', 'flat_use', 'handling_fee', 'handling_percentage', 'call_for_estimate', 'discount_rate', 'display', 'override_is_international');
    }

    //    public function distributors_shipstation()
    //    {
    //        return $this->hasOne(DistributorsShipstation::class);
    //    }
    //
    //    public function distributors_up()
    //    {
    //        return $this->hasOne(DistributorUps::class);
    //    }
    //
    //    public function distributors_usp()
    //    {
    //        return $this->hasOne(DistributorUsps::class);
    //    }

    public function inventoryAccount()
    {
        return $this->hasMany(InventoryAccount::class);
    }

    public function scheduledTaskProducts()
    {
        return $this->hasMany(InventoryScheduledTaskProduct::class, 'products_distributors_id');
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    public function products()
    {
        //todo
        return $this->hasManyThrough(
            Product::class,
            ProductDistributor::class,
        )
            ->withPivot('id', 'stock_qty', 'outofstockstatus_id', 'cost', 'inventory_id');
    }

    public function productFulfillmentRules()
    {
        return $this->belongsToMany(FulfillmentRule::class, 'products_rules_fulfillment_distributors', 'distributor_id', 'rule_id')
            ->withPivot('id', 'rank');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
