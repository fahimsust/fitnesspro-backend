<?php

namespace Domain\Distributors\Models;

use Domain\Products\Actions\LoadProductAvailabilityById;
use Domain\Products\Models\Product\ProductAvailability;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;
use Support\Traits\BelongsTo\BelongsToDistributor;
use Support\Traits\HasModelUtilities;

/**
 * Class DistributorsAvailability
 *
 * @property int $id
 * @property int $distributor_id
 * @property int $availability_id
 * @property string|null $display
 * @property float|null $qty_min
 * @property float|null $qty_max
 *
 * @property ProductAvailability $products_availability
 * @property Distributor $distributor
 *
 * @package Domain\Distributors\Models
 */
class DistributorAvailability extends Model
{
    use HasFactory,
        HasModelUtilities,
        BelongsToDistributor;

    public $timestamps = false;

    protected $table = 'distributors_availabilities';

    protected $casts = [
        'distributor_id' => 'int',
        'availability_id' => 'int',
        'qty_min' => 'float',
        'qty_max' => 'float',
    ];

    protected $fillable = [
        'distributor_id',
        'availability_id',
        'display',
        'qty_min',
        'qty_max',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::deleted(function (DistributorAvailability $distributorAvailability) {
            $distributorAvailability->clearCaches();
        });

        static::updated(function (DistributorAvailability $distributorAvailability) {
            $distributorAvailability->clearCaches();
        });
    }

    public function clearCaches(): void
    {
        Cache::tags([
            'distributor-availability-id-cache.' . $this->distributor_id
        ])->flush();
    }

    public function availability(): BelongsTo
    {
        return $this->belongsTo(
            ProductAvailability::class,
            'availability_id'
        );
    }

    public function availabilityCached(): ProductAvailability
    {
        return LoadProductAvailabilityById::now($this->availability_id);
    }
}
