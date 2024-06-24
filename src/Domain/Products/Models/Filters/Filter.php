<?php

namespace Domain\Products\Models\Filters;

use Domain\Products\Enums\FilterFieldTypes;
use Domain\Products\Enums\FilterTypes;
use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\ProductAvailability;
use Domain\Products\ValueObjects\FilterField;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Http\Request;
use Support\Traits\HasModelUtilities;

/**
 * Class Filter
 *
 * @property int $id
 * @property string $name
 * @property string $label
 * @property bool $status
 * @property int $rank
 * @property bool $show_in_search
 * @property FilterTypes $type
 * @property FilterFieldTypes $field_type
 * @property bool $override_parent
 *
 * @property Collection|array<Attribute> $attributes
 * @property Collection|array<FilterAvailability> $filters_availabilities
 * @property Collection|array<FilterCategory> $filters_categories
 * @property Collection|array<FilterPricing> $filters_pricings
 * @property Collection|array<FilterProductOption> $filters_productoptions
 *
 * @package Domain\Filters\Models
 */
class Filter extends Model
{
    use HasModelUtilities,
        HasFactory;

    public $timestamps = false;
    protected $table = 'filters';

    protected $casts = [
        'status' => 'bool',
        'rank' => 'int',
        'show_in_search' => 'bool',
        'type' => FilterTypes::class,
        'field_type' => FilterFieldTypes::class,
        'override_parent' => 'bool',
    ];

    protected $fillable = [
        'name',
        'label',
        'status',
        'rank',
        'show_in_search',
        'type',
        'field_type',
        'override_parent',
    ];

    public function filterAttributes()
    {
        return $this->hasMany(FilterAttribute::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(
            Attribute::class,
            FilterAttribute::class,
        )
            ->withPivot('label', 'rank', 'status');
    }

    public function availabilities()
    {
        //todo
        return $this->hasManyThrough(
            ProductAvailability::class,
            FilterAvailability::class
        );
    }

    public function filterAvailabilities(): HasMany
    {
        return $this->hasMany(FilterAvailability::class);
    }

    public function categories()
    {
        //todo
        return $this->hasManyThrough(
            Category::class,
            FilterCategory::class
        );
    }

    public function filterCategories()
    {
        return $this->hasMany(FilterCategory::class);
    }

    public function pricing(): HasMany
    {
        return $this->hasMany(FilterPricing::class);
    }

    public function productOptions()
    {
        return $this->hasMany(FilterProductOption::class);
    }
}
