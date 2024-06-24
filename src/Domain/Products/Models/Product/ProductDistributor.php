<?php

namespace Domain\Products\Models\Product;

use Domain\Distributors\Actions\GetCalculatedAvailability;
use Domain\Distributors\Models\Distributor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Support\Traits\BelongsTo\BelongsToDistributor;
use Support\Traits\BelongsTo\BelongsToProduct;
use Support\Traits\HasModelUtilities;

/**
 * Class ProductsDistributor
 *
 * @property int $id
 * @property int $product_id
 * @property int $distributor_id
 * @property float $stock_qty
 * @property int|null $outofstockstatus_id
 * @property float|null $cost
 * @property string $inventory_id
 *
 * @property Distributor $distributor
 * @property Product $product
 * @property Collection|array<ProductLog> $products_logs
 *
 * @package Domain\Products\Models\Product
 */
class ProductDistributor extends Model
{
    use HasFactory,
        HasModelUtilities,
        HasRelationships,
        BelongsToProduct,
        BelongsToDistributor;

    public $timestamps = false;

    public static $wantedPivotValues = [
        'stock_qty',
        'outofstockstatus_id',
        'cost',
    ];

    protected $table = 'products_distributors';

    protected $casts = [
        'product_id' => 'int',
        'distributor_id' => 'int',
        'stock_qty' => 'float',
        'outofstockstatus_id' => 'int',
        'cost' => 'float',
    ];

    protected $fillable = [
        'product_id',
        'distributor_id',
        'stock_qty',
        'outofstockstatus_id',
        'cost',
        'inventory_id',
    ];


    protected static function boot()
    {
        parent::boot();

        static::deleted(function (ProductDistributor $prodDist) {
            $prodDist->clearCaches();
        });

        static::updated(function (ProductDistributor $prodDist) {
            $prodDist->clearCaches();
        });
    }

    public function clearCaches()
    {
        Cache::tags([
            'product-distributor-id-cache.' . $this->distributor_id . '.' . $this->product_id,
            'product-distributor-product-id-cache.' . $this->product_id,
            'product-distributor-distributor-id-cache.' . $this->distributor_id,
        ])
            ->flush();
    }

    public function outOfStockStatus(): BelongsTo
    {
        return $this->belongsTo(
            ProductAvailability::class,
            'outofstockstatus_id'
        );
    }

    public function calculatedAvailability(): ProductAvailability
    {
        return GetCalculatedAvailability::run(
            $this->distributor_id,
            $this->stock_qty
        );
    }
}
