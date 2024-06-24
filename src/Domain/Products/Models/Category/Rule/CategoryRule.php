<?php

namespace Domain\Products\Models\Category\Rule;

use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Category\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Enums\MatchAllAnyString;
use Support\Traits\HasModelUtilities;

class CategoryRule extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'categories_rules';
    protected $casts = [
        'category_id' => 'int',
        'temp_id' => 'int',
        'match_type' => MatchAllAnyString::class,
    ];

    protected $fillable = [
        'category_id',
        'temp_id',
        'match_type',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function categoryRuleAttributes()
    {
        return $this->hasMany(
            CategoryRuleAttribute::class,
            'rule_id'
        );
    }

    public function attributeOptions()
    {
        return $this->belongsToMany(
            AttributeOption::class,
            CategoryRuleAttribute::class,
            'rule_id',
            'value_id'
        );
    }
}
