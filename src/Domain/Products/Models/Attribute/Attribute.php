<?php

namespace Domain\Products\Models\Attribute;

use Domain\Products\Models\Filters\Filter;
use Domain\Products\Models\Filters\FilterAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Support\Traits\HasModelUtilities;

class Attribute extends Model
{
    use HasFactory,
        HasModelUtilities,
        HasRelationships;

    protected $table = 'attributes';

    protected $casts = [
        'type_id' => 'int',
        'show_in_details' => 'bool',
        'show_in_search' => 'bool',
    ];

    protected $fillable = [
        'name',
        'type_id',
        'show_in_details',
        'show_in_search',
    ];

    public function type()
    {
        return $this->belongsTo(AttributeType::class, 'type_id');
    }

    public function products()
    {
        return $this->hasManyDeepFromRelations(
            $this->options(), (new AttributeOption)->products()
        );
        // return $this->hasManyDeep(
        //     Product::class,
        //     [AttributeOption::Table(), ProductAttribute::class],
        //     [null, 'option_id', 'id'],
        //     [null, 'id', 'product_id']
        // );
    }

    public function options()
    {
        return $this->hasMany(AttributeOption::class);
    }

    public function attributeSetAttributes()
    {
        return $this->hasMany(AttributeSetAttribute::class);
    }

    public function filterAttribute()
    {
        return $this->hasMany(FilterAttribute::class);
    }

    public function attributeSets()
    {
        //todo
        return $this->hasManyThrough(
            AttributeSet::class,
            AttributeSetAttribute::class
        );
    }

    public function filters()
    {
        //todo
        return $this->hasManyThrough(
            Filter::class,
            FilterAttribute::class,
        )
            ->withPivot('label', 'rank', 'status');
    }

    public function translations()
    {
        return $this->hasMany(
            AttributeTranslation::class
        );
    }
}
