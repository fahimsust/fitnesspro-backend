<?php

namespace Domain\Products\Models;

use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryBrand;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\QueryBuilders\BrandQuery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class Brand extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $timestamps = false;
    protected $table = 'brands';

    protected $fillable = [
        'name',
    ];

    public function newEloquentBuilder($query)
    {
        return new BrandQuery($query);
    }

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            CategoryBrand::class,
            'brand_id',
            'category_id'
        );
    }
    public function categoryBrands()
    {
        return $this->hasMany(
            CategoryBrand::class
        );
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            ProductDetail::class,
            'brand_id',
            'product_id'
        );
    }
    public function productDetail()
    {
        return $this->hasMany(
            ProductDetail::class
        );
    }
}
