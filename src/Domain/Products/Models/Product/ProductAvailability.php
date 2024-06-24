<?php

namespace Domain\Products\Models\Product;

use Domain\Discounts\Models\Rule\Condition\ConditionProductAvailability;
use Domain\Distributors\Models\Distributor;
use Domain\Distributors\Models\DistributorAvailability;
use Domain\Products\QueryBuilders\ProductAvailabilityQuery;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kirschbaum\PowerJoins\PowerJoins;
use Support\Traits\HasModelUtilities;

/**
 * Class ProductsAvailability
 *
 * @property int $id
 * @property string $name
 * @property string|null $display
 * @property float|null $qty_min
 * @property float|null $qty_max
 * @property bool $auto_adjust
 *
 * @property Collection|array<ConditionProductAvailability> $discount_rule_condition_productavailabilities
 * @property Collection|array<DistributorAvailability> $distributors_availabilities
 *
 * @package Domain\Products\Models\Product
 */
class ProductAvailability extends Model
{
    use HasFactory,
        HasModelUtilities,
        PowerJoins;
    public $timestamps = false;

    protected $table = 'products_availability';

    protected $casts = [
        'qty_min' => 'float',
        'qty_max' => 'float',
        'auto_adjust' => 'bool',
    ];

    protected $fillable = [
        'name',
        'display',
        'qty_min',
        'qty_max',
        'auto_adjust',
    ];

    public function newEloquentBuilder($query)
    {
        return new ProductAvailabilityQuery($query);
    }

    //  public function discountConditions()
    //  {
//        //todo if needed
//      return $this->hasManyThrough(
//            DiscountCondition::class,
//            ConditionProductAvailability::class,
//            'availability_id'
//        );
    //  }

    public function distributorAvailability(): HasMany
    {
        return $this->hasMany(
            DistributorAvailability::class,
            'availability_id'
        );
    }

    public function distributors()
    {
        //todo if needed
        return $this->hasManyThrough(
            Distributor::class,
            DistributorAvailability::class,
            'availability_id'
        );
    }
}
