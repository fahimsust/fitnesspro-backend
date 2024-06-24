<?php

namespace Domain\Products\Models\Filters;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FiltersPricing
 *
 * @property int $id
 * @property int $filter_id
 * @property string $label
 * @property int $rank
 * @property bool $status
 * @property float|null $price_min
 * @property float|null $price_max
 *
 * @property Filter $filter
 *
 * @package Domain\Filters\Models
 */
class FilterPricing extends Model
{
    public $timestamps = false;
    protected $table = 'filters_pricing';

    protected $casts = [
        'filter_id' => 'int',
        'rank' => 'int',
        'status' => 'bool',
        'price_min' => 'float',
        'price_max' => 'float',
    ];

    protected $fillable = [
        'filter_id',
        'label',
        'rank',
        'status',
        'price_min',
        'price_max',
    ];

    public function filter()
    {
        return $this->belongsTo(Filter::class);
    }
}
