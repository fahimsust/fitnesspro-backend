<?php

namespace Domain\Products\Models\Attribute;

use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAttribute;
use Domain\Products\Models\Product\ProductType;
use Domain\Products\Models\Product\ProductTypeAttributeSet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class AttributeSet extends Model
{
    use HasFactory,
        HasModelUtilities,
        HasRelationships;

    protected $table = 'attributes_sets';

    protected $fillable = [
        'name',
    ];

    public function products()
    {
        return $this->hasManyDeepFromRelations(
            $this->attributes(), (new Attribute)->products()
        );
    }
    public function options()
    {
        return $this->hasManyDeepFromRelations(
            $this->attributes(), (new Attribute)->options()
        );
    }

    public function attributes()
    {
        return $this->belongsToMany(
            Attribute::class,
            AttributeSetAttribute::class,
            'set_id',
            'attribute_id'
        );
    }

    public function attributesSetAttribute()
    {
        return $this->hasMany(
            AttributeSetAttribute::class,
            'set_id',
        );
    }

    public function attributesSetProductType()
    {
        return $this->hasMany(
            ProductTypeAttributeSet::class,
            'set_id',
        );
    }

    public function productTypes()
    {
        return $this->belongsToMany(
            ProductType::class,
            ProductTypeAttributeSet::class,
            'set_id',
            'type_id'
        );
    }
    public function translations()
    {
        return $this->hasMany(
            AttributeSetTranslation::class,
            'set_id'
        );
    }
}
