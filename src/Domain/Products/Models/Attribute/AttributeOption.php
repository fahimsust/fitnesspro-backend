<?php

namespace Domain\Products\Models\Attribute;

use Domain\Products\Contracts\IsReviewable;
use Domain\Products\Models\Category\Rule\CategoryRuleAttribute;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAttribute;
use Domain\Products\QueryBuilders\AttributeOptionQuery;
use Domain\Products\Traits\HasReviews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Support\Traits\HasModelUtilities;

class AttributeOption extends Model implements IsReviewable
{
    use HasFactory,
        HasModelUtilities,
        HasReviews,
        HasRelationships;

    protected $table = 'attributes_options';

    protected $fillable = [
        'attribute_id',
        'display',
        'value',
        'rank',
        'status',
    ];

    protected $casts = [
        'rank' => 'int',
        'status' => 'bool',
    ];

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(
            Attribute::class,
            'attribute_id',
            'id'
        );
    }
    public function newEloquentBuilder($query)
    {
        return new AttributeOptionQuery($query);
    }

    public function categoryAttributes()
    {
        return $this->hasMany(
            CategoryRuleAttribute::class,
            'value_id'
        );
    }

    public function categories(): HasManyDeep
    {
        return $this->hasManyDeepFromRelations(
            $this->categoryAttributes(),
            (new CategoryRuleAttribute)->category()
        );
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            ProductAttribute::class,
            'option_id',
            'product_id'
        );
    }

    public function productAttributes()
    {
        return $this->hasMany(
            ProductAttribute::class,
            'option_id'
        );
    }

    public function translations()
    {
        return $this->hasMany(
            AttributeOptionTranslation::class,
            'option_id'
        );
    }
}
