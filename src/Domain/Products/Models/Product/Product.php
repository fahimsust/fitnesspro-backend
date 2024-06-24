<?php

namespace Domain\Products\Models\Product;

use Domain\Accounts\Models\Specialty;
use Domain\Content\Models\Image;
use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\ProductForm;
use Domain\Discounts\Models\Advantage\AdvantageProduct;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Level\DiscountLevel;
use Domain\Discounts\Models\Level\DiscountLevelProduct;
use Domain\Discounts\Models\Rule\Condition\ConditionProduct;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Distributors\Models\Distributor;
use Domain\Distributors\Models\Inventory\InventoryScheduledTask;
use Domain\Distributors\Models\Inventory\InventoryScheduledTaskProduct;
use Domain\Future\GiftRegistry\RegistryItem;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Products\Actions\Pricing\LoadProductPricingForSiteFromCache;
use Domain\Products\Contracts\IsReviewable;
use Domain\Products\Enums\ProductOptionTypes;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\BookingAs\BookingAs;
use Domain\Products\Models\BookingAs\BookingAsProduct;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryFeaturedProduct;
use Domain\Products\Models\Category\CategoryProductHide;
use Domain\Products\Models\Category\CategoryProductShow;
use Domain\Products\Models\FulfillmentRules\FulfillmentRule;
use Domain\Products\Models\Product\AccessoryField\AccessoryField;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Settings\ProductSettings;
use Domain\Products\Models\Product\Settings\ProductSettingsTemplateModuleValue;
use Domain\Products\Models\Product\Settings\ProductSiteSettings;
use Domain\Products\Models\Product\Settings\ProductSiteSettingsModuleValue;
use Domain\Products\Models\Product\Specialties\ProductSpecialty;
use Domain\Products\QueryBuilders\ProductQuery;
use Domain\Products\Traits\HasReviews;
use Domain\Resorts\Models\Resort;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Kirschbaum\PowerJoins\PowerJoins;
use Support\Traits\HasModelUtilities;

class Product extends Model implements IsReviewable
{
    use HasFactory,
        HasModelUtilities,
        HasReviews,
        PowerJoins,
        SoftDeletes;

    public const CREATED_AT = 'created';
    public const UPDATED_AT = null;

    public static $loadForCartRelations = [
        'fulfillmentRule',
        'defaultAvailability',
        'details' => [
            'brand',
            'category',
            'type',
        ],
        'attributeOptions',
    ];

    protected $fillable = [
        'parent_product',
        'title',
        'subtitle',
        'default_outofstockstatus_id',
        'details_img_id',
        'category_img_id',
        'status',
        'product_no',
        'combined_stock_qty',
        'default_cost',
        'weight',
        'created',
        'default_distributor_id',
        'fulfillment_rule_id',
        'url_name',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'inventory_id',
        'customs_description',
        'tariff_number',
        'country_origin',
        'inventoried',
        'shared_inventory_id',
        'addtocart_setting',
        'addtocart_external_label',
        'addtocart_external_link',
        'has_children',
    ];

    protected $casts = [
        'parent_product' => 'int',
        'default_outofstockstatus_id' => 'int',
        'details_img_id' => 'int',
        'category_img_id' => 'int',
        'status' => 'int',
        'combined_stock_qty' => 'int',
        'default_cost' => 'int',
        'weight' => 'decimal:2',
        'default_distributor_id' => 'int',
        'fulfillment_rule_id' => 'int',
        'inventoried' => 'bool',
        'has_children' => 'bool',
        'created' => 'datetime',
    ];

    private array $pricingBySiteCached = [];
    private array $pricingForSiteCached = [];

    public function usesTimestamps()
    {
        return true;
    }

    protected static function boot()
    {
        parent::boot();

        static::deleted(function (Product $product) {
            $product->clearCaches();
        });

        static::updated(function (Product $product) {
            $product->clearCaches();
        });
    }

    public function clearCaches(): void
    {
        Cache::tags(
            'product-id-cache.' . $this->childProductId
        )
            ->flush();
    }

    public function newEloquentBuilder($query)
    {
        return new ProductQuery($query);
    }

    public function isActive(): bool
    {
        return $this->status;
    }

    public function images(bool|null $showInGallery = true): BelongsToMany
    {
        return $this->belongsToMany(
            Image::class,
            ProductImage::class,
            'product_id',
            'image_id',
        );

        // return is_null($showInGallery)
        //     ? $query
        //     : $query->where('show_in_gallery', $showInGallery);
    }

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function details(): HasOne
    {
        if ($this->hasParent()) {
            return $this->parent->details();
        }

        return $this->hasOne(ProductDetail::class);
    }

    public function specialties()
    {
        return $this->hasManyThrough(
            Specialty::class,
            ProductSpecialty::class,
            'product_id',
            'id',
            'id',
            'specialty_id'
        )->whereStatus(true);
    }

    public function detailsImage()
    {
        return $this->belongsTo(
            Image::class,
            'details_img_id'
        );
    }

    public function thumbnailImage()
    {
        return $this->belongsTo(
            Image::class,
            'category_img_id'
        );
    }

    public function defaultDistributor(): BelongsTo
    {
        return $this->belongsTo(
            Distributor::class,
            'default_distributor_id'
        );
    }

    public function defaultDistributorId(): ?int
    {
        return $this->default_distributor_id
            ?? $this->parent?->default_distributor_id;
    }

    public function productDistributors(): HasMany
    {
        return $this->hasMany(ProductDistributor::class);
    }

    public function distributors(): BelongsToMany
    {
        return $this->belongsToMany(
            Distributor::class,
            ProductDistributor::class,
            'product_id',
            'distributor_id',
        )->withPivot(ProductDistributor::$wantedPivotValues);
    }

    public function parent()
    {
        return $this->belongsTo(Product::class, 'parent_product');
    }

    public function hasParent(): bool
    {
        return !is_null($this->parent_product);
    }

    public function isInventoried(): bool
    {
        return (bool)$this->inventoried ?? $this->parent?->inventoried;
    }

    public function defaultCost(): ?int
    {
        return $this->default_cost
            ?? $this->parent?->default_cost;
    }

    public function defaultOutOfStockStatusId(): int
    {
        return $this->default_outofstockstatus_id
            ?? $this->parent?->default_outofstockstatus_id;
    }

    public function variants(): HasMany
    {
        return $this->hasMany(Product::class, 'parent_product');
    }

    public function variantOptions(): HasMany
    {
        return $this->hasMany(
            ProductVariantOption::class,
            'product_id'
        );
    }

    public function optionValues()
    {
        return $this->belongsToMany(
            ProductOptionValue::class,
            ProductVariantOption::class,
            'product_id',
            'option_id'
        );
    }

    public function productAccessoryFields()
    {
        return $this->hasMany(
            ProductAccessoryField::class, //'products_accessories_fields',
        );
    }

    public function accessoryFields(): BelongsToMany
    {
        return $this->belongsToMany(
            AccessoryField::class,
            ProductAccessoryField::class, //'products_accessories_fields',
            'product_id',
            'accessories_fields_id'
        )
            ->withPivot('rank');
    }

    public function bookingAs()
    {
        return $this->belongsToMany(
            BookingAs::class,
            BookingAsProduct::class, //'bookingas_products',
            'product',
            'bookingas_id'
        );
    }

    //    public function bulkEditActivities()
    //    {
    //        //todo
    //        return $this->belongsToMany(
    //            BulkEditActivity::class,
    //            BulkEditActivityProduct::class,
    //            'product_id',
    //            'change_id'
    //        )
    //            ->withPivot('changed_from');
    //    }

    public function featuredInCategories()
    {
        return $this->hasManyThrough(
            Category::class,
            CategoryFeaturedProduct::class,
            'product_id',
            'id',
            'id',
            'category_id',
        );
    }

    public function showInCategories()
    {
        return $this->belongsToMany(
            Category::class,
            CategoryProductShow::class,
            'product_id',
            'category_id',
            'id',
            'id',
        )->withPivot('manual');
    }

    public function hideFromCategories()
    {
        return $this->hasManyThrough(
            Category::class,
            CategoryProductHide::class,
            'product_id',
            'id',
            'id',
            'category_id',
        );
    }

    public function productForms()
    {
        return $this->hasMany(
            ProductForm::class
        );
    }

    public function customForms()
    {
        return $this->belongsToMany(
            CustomForm::class,
            ProductForm::class,
            'product_id',
            'form_id'
        )
            ->withPivot('rank');
    }

    public function discountAdvantages()
    {
        //todo
        return $this->belongsToMany(
            DiscountAdvantage::class,
            AdvantageProduct::class,
            'product_id',
            'advantage_id'
        )
            ->withPivot('applyto_qty');
    }

    public function discountConditions()
    {
        //todo
        return $this->belongsToMany(
            DiscountCondition::class,
            ConditionProduct::class,
            'product_id',
            'condition_id'
        )
            ->withPivot('required_qty');
    }

    public function discountLevels()
    {
        //todo
        return $this->belongsToMany(
            DiscountLevel::class,
            DiscountLevelProduct::class,
            'product_id',
            'discount_level_id'
        )
            ->withPivot('id');
    }

    public function registryItems()
    {
        return $this->hasMany(RegistryItem::class);
    }

    public function inventoryScheduledTasks()
    {
        //todo
        return $this->belongsToMany(
            InventoryScheduledTask::class,
            InventoryScheduledTaskProduct::class,
            'products_id',
            'task_id'
        )
            ->withPivot('id', 'products_distributors_id', 'created');
    }

    public function orders()
    {
        //todo
        return $this->hasManyThrough(
            Order::class,
            OrderItem::class,
        )
            ->withPivot('id', 'product_qty', 'product_price', 'product_notes', 'product_saleprice', 'product_onsale', 'actual_product_id', 'package_id', 'parent_product_id', 'cart_id', 'product_label', 'registry_item_id', 'free_from_discount_advantage');
    }

    public function productAccessories()
    {
        return $this->hasMany(ProductAccessory::class);
    }

    public function accessories()
    {
        return $this->belongsToMany(
            Product::class,
            ProductAccessory::class,
            'product_id',
            'accessory_id'
        )->withPivot([
            'required',
            'show_as_option',
            'discount_percentage',
            'description',
            'link_actions',
        ]);
    }

    public function attributeOptions()
    {
        return $this->hasManyThrough(
            AttributeOption::class,
            ProductAttribute::class,
            'product_id',
            'id',
            'id',
            'option_id',
        );
    }

    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function logs()
    {
        return $this->hasMany(ProductLog::class);
    }

    public function needsChild()
    {
        return $this->hasOne(ProductNeedsVariant::class);
    }

    public function options()
    {
        return $this->hasMany(ProductOption::class);
    }

    public function rangeOption()
    {
        return $this->hasMany(ProductOption::class)->where('type_id', ProductOptionTypes::DateRange);
    }

    public function pricing(): HasMany
    {
        return $this->hasMany(ProductPricing::class);
    }

    public function pricingForCurrentSite(): HasOne
    {
        if (!config('site.id')) {
            throw new \Exception('Cannot load pricing current current site: Site ID not set');
        }

        return $this->pricingForSite(config('site.id'));
    }

    public function pricingForSite(?int $siteId): HasOne
    {
        return $this->hasOne(ProductPricing::class)
            ->forSite($siteId);
    }

    public function pricingForSiteCached(?int $siteId): ProductPricing
    {
        return $this->pricingForSiteCached[$siteId] ??= LoadProductPricingForSiteFromCache::now(
            $this,
            $siteId,
        );
    }

    public function pricingBySite(Site $site): ProductPricing
    {
        if (isset($this->pricingBySiteCached[$site->id])) {
            return $this->pricingBySiteCached[$site->id];
        }

        return $this->pricingBySiteCached[$site->id] ??= $this->pricing()
            ->forSite($site)
            ->with(['pricingRule.levels', 'orderingRule'])
            ->firstOrFail();
    }

    public function pricingBySiteCached(Site $site): ProductPricing
    {
        if (isset($this->pricingBySiteCached[$site->id])) {
            return $this->pricingBySiteCached[$site->id];
        }

        $this->pricingBySiteCached[$site->id] = $this->pricingForSiteCached($site->id);

        $this->pricingBySiteCached[$site->id]
            ->pricingRuleCached()
            ?->levelsCached();

        $this->pricingBySiteCached[$site->id]
            ->orderingRuleCached();

        return $this->pricingBySiteCached[$site->id];
    }

    public function relatedProducts(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            ProductRelated::class,
            'product_id',
            'related_id'
        );
    }

    public function resort()
    {
        //todo
        return $this->hasOneThrough(
            Resort::class,
            ProductResort::class,
        );
    }

    public function productRelated()
    {
        return $this->hasMany(ProductRelated::class, 'product_id');
    }

    public function settings()
    {
        return $this->hasOne(ProductSettings::class);
    }

    public function templateModuleSettings()
    {
        return $this->hasMany(
            ProductSettingsTemplateModuleValue::class
        );
    }

    public function sitesModuleSettings()
    {
        return $this->hasMany(
            ProductSiteSettingsModuleValue::class,
        )
            ->withPivot('id', 'section_id', 'module_id', 'field_id', 'custom_value');
    }

    public function siteSettings()
    {
        return $this->hasMany(
            ProductSiteSettings::class,
        );
    }

    public function useSiteSettings(): HasOne
    {
        if ($this->hasParent()) {
            return $this->hasOne(
                ProductSiteSettings::class,
                'parent_product',
            );
        }

        return $this->hasOne(
            ProductSiteSettings::class,
        );
    }

    public function tasks()
    {
        return $this->hasMany(ProductTask::class);
    }

    public function views()
    {
        return $this->hasOne(ProductView::class);
    }

    public function fulfillmentRule(): BelongsTo
    {
        return $this->belongsTo(FulfillmentRule::class);
    }

    public function defaultAvailability(): BelongsTo
    {
        return $this->belongsTo(
            ProductAvailability::class,
            'default_outofstockstatus_id'
        );
    }

    public function brand(): ?Brand
    {
        return $this->details?->brand;
    }

    public function type(): ?ProductType
    {
        return $this->details?->type;
    }

    public function defaultCategory(): ?Category
    {
        return $this->details?->category;
    }

    public function isDigital(): bool
    {
        return (bool)$this->details?->downloadable;
    }

    public function translations(): HasMany
    {
        return $this->hasMany(ProductTranslation::class);
    }

    public function weight(): float
    {
        return $this->weight
            ?? $this->parent?->weight()
            ?? 0;
    }
}
