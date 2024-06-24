<?php

namespace Domain\Products\Models\Product;

use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\ProductFormType;
use Domain\Discounts\Models\Advantage\AdvantageProductType;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Rule\Condition\ConditionProductType;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Products\Models\Attribute\AttributeSet;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryProductType;
use Domain\Products\QueryBuilders\ProductTypeQuery;
use Domain\Tax\Models\TaxRule;
use Domain\Tax\Models\TaxRuleProductType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class ProductType extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'products_types';

    public function newEloquentBuilder($query)
    {
        return new ProductTypeQuery($query);
    }

    public function categories()
    {
        //todo
        return $this->hasManyThrough(
            Category::class,
            CategoryProductType::class,
            'type_id'
        );
    }

    public function customForms()
    {
        //todo
        return $this->hasManyThrough(
            CustomForm::class,
            ProductFormType::class,
            'product_type_id'
        );
    }

    public function discountAdvantages()
    {
        //todo
        return $this->hasManyThrough(
            DiscountAdvantage::class,
            AdvantageProductType::class,
            'producttype_id'
        );
    }

    public function discountConditions()
    {
        //todo
        return $this->hasManyThrough(
            DiscountCondition::class,
            ConditionProductType::class,
            'producttype_id'
        );
    }
//
//  public function orders_customforms()
//  {
//      return $this->hasMany(OrderCustomForm::class, 'product_type_id');
//  }
//
//  public function products_details()
//  {
//      return $this->hasMany(ProductDetail::class, 'type_id');
//  }
    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            ProductDetail::class,
            'type_id',
            'product_id'
        );
    }

    public function productTypeAttributeSets()
    {
        return $this->hasMany(ProductTypeAttributeSet::class, 'type_id');
    }
    public function attributeSets()
    {
        return $this->belongsToMany(
            AttributeSet::class,
            ProductTypeAttributeSet::class,
            'type_id',
            'set_id'
        );
    }
    public function taxRuleProductType()
    {
        return $this->hasMany(TaxRuleProductType::class, 'type_id');
    }

    public function taxRules()
    {
        return $this->belongsToMany(
            TaxRule::class,
            TaxRuleProductType::class,
            'type_id',
            'tax_rule_id'
        );
    }
}
