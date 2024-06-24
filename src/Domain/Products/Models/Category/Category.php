<?php

namespace Domain\Products\Models\Category;

use Domain\Content\Models\Menus\Menu;
use Domain\Content\Models\Menus\MenusCatalogCategories;
use Domain\Products\Actions\Categories\LoadCategoryById;
use Domain\Products\Actions\Categories\LoadSubcategoriesByCategoryId;
use Domain\Products\Enums\Category\CategoryStatus;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category\Rule\CategoryRule;
use Domain\Products\Models\Category\Rule\CategoryRuleAttribute;
use Domain\Products\Models\Filters\Filter;
use Domain\Products\Models\Filters\FilterCategory;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductSortOption;
use Domain\Products\Models\Product\ProductType;
use Domain\Products\QueryBuilders\CategoryQuery;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Support\Enums\MatchAllAnyString;
use Support\Traits\BelongsTo\BelongsToImage;
use Support\Traits\ClearsCache;
use Support\Traits\HasModelUtilities;

class Category extends Model
{
    use HasFactory,
        HasModelUtilities,
        BelongsToImage,
        ClearsCache;

    public $timestamps = false;

    protected $table = 'categories';

    protected $casts = [
        'parent_id' => 'int',
        'image_id' => 'int',
        'rank' => 'int',
        'status' => CategoryStatus::class,
        'show_sale' => 'bool',
        'limit_min_price' => 'bool',
        'min_price' => 'float',
        'limit_max_price' => 'bool',
        'max_price' => 'float',
        'show_in_list' => 'bool',
        'limit_days' => 'int',
        'show_types' => 'bool',
        'show_brands' => 'bool',
        'rules_match_type' => MatchAllAnyString::class,
        'inventory_id' => 'int',
    ];

    private Category $parentCached;

    protected function cacheTags(): array
    {
        $array = [
            "category-cache.{$this->id}",
            "category-slug-cache.{$this->url_name}",
        ];

        if ($this->parent_id) {
            $array[] = "category-cache.{$this->parent_id}";
        }

        return $array;
    }

    public function newEloquentBuilder($query)
    {
        return new CategoryQuery($query);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(
            Category::class,
            'parent_id'
        );
    }

    public function parentCached(): ?Category
    {
        if (!$this->parent_id) {
            return null;
        }

        if ($this->relationLoaded('parent')) {
            return $this->parent;
        }

        $this->parentCached ??= LoadCategoryById::now($this->parent_id);

        $this->setRelation('parent', $this->parentCached);

        return $this->parentCached;
    }

    public function subcategories(): HasMany
    {
        return $this->hasMany(
            Category::class,
            'parent_id'
        );
    }

    public function subcategoriesCached(): Collection
    {
        if ($this->relationLoaded('subcategories')) {
            return $this->subcategories;
        }

        $this->subcategoriesCached ??= LoadSubcategoriesByCategoryId::now($this->id);

        $this->setRelation('subcategories', $this->subcategoriesCached);

        return $this->subcategoriesCached;
    }

//    public function filteringAttributes()
//    {
//        //todo
//        return $this->hasManyThrough(
//            AttributeOption::class,
//            CategoryAttributeUNUSED::class
//        );
//    }

    public function filteringRuleAttribute()
    {
        return $this->hasMany(CategoryRuleAttribute::class);
    }

    public function featuredProducts()
    {
        return $this->belongsToMany(
            Product::class,
            CategoryFeaturedProduct::class,
            'category_id',
            'product_id'
        )
            ->withPivot('rank')
            ->orderByPivot('rank');
    }

    public function categoryFeaturedProducts()
    {
        return $this->hasMany(CategoryFeaturedProduct::class);
    }

    public function categoryProductShows()
    {
        return $this->hasMany(CategoryProductShow::class);
    }

    public function categoryProductHides()
    {
        return $this->hasMany(CategoryProductHide::class);
    }

    public function productsToShow()
    {
        return $this->belongsToMany(
            Product::class,
            CategoryProductShow::class,
            'category_id',
            'product_id'
        )->withPivot('rank')
            ->orderByPivot('rank');
    }

    public function productsToHide()
    {
        return $this->belongsToMany(
            Product::class,
            CategoryProductHide::class,
            'category_id',
            'product_id'
        );
    }

    public function filteringBrands()
    {
        return $this->belongsToMany(
            Brand::class,
            CategoryBrand::class,
            'category_id',
            'brand_id'
        );
    }

    public function categoryBrands()
    {
        return $this->hasMany(CategoryBrand::class);
    }

    public function productRanking()
    {
        return $this->hasMany(CategoryProductRank::class);
    }

    public function productSortOptions()
    {
        //todo
        return $this->hasManyThrough(
            ProductSortOption::class,
            CategoryProductSortOption::class
        );
    }

    public function rules()
    {
        return $this->hasMany(CategoryRule::class);
    }

    public function settings()
    {
        return $this->hasOne(CategorySettings::class);
    }

    public function siteSettings()
    {
        return $this->hasMany(CategorySiteSettings::class);
    }

    public function calculatedSetting(string $key): mixed
    {
        return $this->settings->{$key} ?? null;
    }

    public function siteModuleValues()
    {
        return $this->hasMany(CategorySettingsSiteModuleValue::class);
    }

    public function settingsTemplate()
    {
        return $this->hasOne(
            CategorySettingsTemplate::class
        );
    }

    public function settingsTemplateModuleValues()
    {
        return $this->hasManyThrough(
            CategorySettingsTemplateModuleValue::class,
            CategorySettingsTemplate::class,
        );
    }

    public function filteringProductTypes()
    {
        return $this->belongsToMany(
            ProductType::class,
            CategoryProductType::class,
            'category_id',
            'type_id'
        );
    }

    public function categoryProductTypes()
    {
        return $this->hasMany(
            CategoryProductType::class
        );
    }

    public function categoryFilters(): HasMany
    {
        return $this->hasMany(
            FilterCategory::class
        );
    }

    public function filters()
    {
        return $this->hasManyThrough(
            Filter::class,
            FilterCategory::class,
            'category_id',
            'id',
            'id',
            'filter_id'
        );
    }

    public function menus()
    {
        //todo
        return $this->hasManyThrough(
            Menu::class,
            MenusCatalogCategories::class
        );
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            ProductDetail::class,
            'default_category_id',
            'product_id'
        );
    }

    public function sites()
    {
        //todo
        return $this->hasManyThrough(
            Site::class,
            SiteCategory::class
        );
    }

    public function translations()
    {
        return $this->hasMany(
            CategoryTranslation::class
        );
    }
}
