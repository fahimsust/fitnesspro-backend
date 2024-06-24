<?php

namespace Domain\Products\Models\Product\Option;

use Domain\Products\Enums\ProductOptionTypes;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductNeedsVariant;
use Domain\Products\QueryBuilders\ProductOptionQuery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Support\Traits\HasModelUtilities;

class ProductOption extends Model
{
    use HasFactory,
        HasModelUtilities,
        PowerJoins,
        HasRelationships;

    protected $table = 'products_options';
    protected $appends = ['option_type'];

    protected $casts = [
        'type_id' => ProductOptionTypes::class,
        'show_with_thumbnail' => 'bool',
        'rank' => 'int',
        'required' => 'bool',
        'product_id' => 'int',
        'is_template' => 'bool',
        'status' => 'bool',
    ];

    protected $fillable = [
        'name',
        'display',
        'type_id',
        'show_with_thumbnail',
        'rank',
        'required',
        'product_id',
        'is_template',
        'status',
    ];

    public function newEloquentBuilder($query)
    {
        return new ProductOptionQuery($query);
    }

    public function scopeRequired(Builder $query)
    {
        return $query->whereRequired(true);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function type(): ProductOptionTypes
    {
        return $this->type_id;
    }
    public function getOptionTypeAttribute(): array
    {
        return
            [
                'id' => $this->attributes['type_id'],
                'name' => ProductOptionTypes::from($this->attributes['type_id'])->label()
            ];
    }

    //    public function optionType()
    //    {
    //        return $this->belongsTo(ProductOptionType::class, 'type_id');
    //    }

    public function needsChild()
    {
        return $this->hasOne(
            ProductNeedsVariant::class,
            'option_id'
        );
    }

    public function optionValues()
    {
        return $this->hasMany(
            ProductOptionValue::class,
            'option_id'
        );
    }

    public function variants()
    {
        return $this->hasManyDeepFromRelations(
            $this->optionValues(),
            (new ProductOptionValue)->variants()
        );
    }

    public function translations()
    {
        return $this->hasMany(ProductOptionTranslation::class);
    }
}
