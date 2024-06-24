<?php

namespace Domain\Products\Models\Filters;

use Domain\Products\Models\Attribute\Attribute;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class FiltersAttribute
 *
 * @property int $attribute_id
 * @property int $filter_id
 * @property string $label
 * @property int $rank
 * @property bool $status
 *
 * @property Attribute $attribute
 * @property Filter $filter
 *
 * @package Domain\Filters\Models
 */
class FilterAttribute extends Model
{
    use HasModelUtilities;

    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'filters_attributes';

    protected $casts = [
        'attribute_id' => 'int',
        'filter_id' => 'int',
        'rank' => 'int',
        'status' => 'bool',
    ];

    protected $fillable = [
        'label',
        'rank',
        'status',
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function filter()
    {
        return $this->belongsTo(Filter::class);
    }
}
