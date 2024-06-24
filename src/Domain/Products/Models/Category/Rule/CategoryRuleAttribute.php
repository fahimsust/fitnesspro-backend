<?php

namespace Domain\Products\Models\Category\Rule;

use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Category\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class CategoryRuleAttribute extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'categories_rules_attributes';
    protected $casts = [
        'rule_id' => 'int',
        'value_id' => 'int',
        'set_id' => 'int',
        'matches' => 'bool',
    ];

    protected $fillable = [
        'rule_id',
        'value_id',
        'set_id',
        'matches',
    ];

    public function category()
    {
        return $this->hasOneThrough(
            Category::class,
            CategoryRule::class,
            'id',
            'id',
            'rule_id',
            'category_id'
        );
    }

    public function rule()
    {
        return $this->belongsTo(CategoryRule::class, 'rule_id');
    }

    public function attributeOption()
    {
        return $this->belongsTo(AttributeOption::class, 'value_id');
    }
}
