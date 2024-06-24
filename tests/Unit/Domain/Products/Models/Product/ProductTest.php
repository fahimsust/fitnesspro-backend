<?php

namespace Tests\Unit\Domain\Products\Models\Product;

use Domain\Accounts\Models\Specialty;
use Domain\Content\Models\Image;
use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\ProductForm;
use Domain\Distributors\Models\Distributor;
use Domain\Products\Enums\ProductReviewItemTypes;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\BookingAs\BookingAs;
use Domain\Products\Models\BookingAs\BookingAsProduct;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryFeaturedProduct;
use Domain\Products\Models\Category\CategoryProductHide;
use Domain\Products\Models\Category\CategoryProductShow;
use Domain\Products\Models\Product\AccessoryField\AccessoryField;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAccessory;
use Domain\Products\Models\Product\ProductAccessoryField;
use Domain\Products\Models\Product\ProductAttribute;
use Domain\Products\Models\Product\ProductAvailability;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductDistributor;
use Domain\Products\Models\Product\ProductImage;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Products\Models\Product\ProductRelated;
use Domain\Products\Models\Product\ProductReview;
use Domain\Products\Models\Product\ProductTranslation;
use Domain\Products\Models\Product\ProductType;
use Domain\Products\Models\Product\Settings\ProductSettings;
use Domain\Products\Models\Product\Settings\ProductSettingsTemplateModuleValue;
use Domain\Products\Models\Product\Settings\ProductSiteSettings;
use Domain\Products\Models\Product\Settings\ProductSiteSettingsModuleValue;
use Domain\Products\Models\Product\Specialties\ProductSpecialty;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class ProductTest extends TestCase
{
    protected Model|Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->product = Product::factory()->create();
    }

    /** @test */
    public function can_seed()
    {
        $product = Product::firstOrFail();

        $this->assertInstanceOf(Product::class, $product);
    }

    /** @test */
    public function can_get_specialties()
    {
        ProductSpecialty::firstOrFactory();

        $this->assertInstanceOf(Specialty::class, $this->product->specialties()->first());
    }

    /** @test */
    public function can_get_images()
    {
        ProductImage::factory()->create(['show_in_gallery' => true]);

        $images = $this->product->images(true)->get();

        $this->assertCount(1, $images);
        $this->assertInstanceOf(Image::class, $images->first());
    }

    /** @test */
    public function can_get_attribute_options()
    {
        ProductAttribute::factory(3)->create([
            'option_id' => AttributeOption::factory()
        ]);

        $this->assertCount(3, $this->product->attributeOptions);
        $this->assertInstanceOf(
            AttributeOption::class,
            $this->product->attributeOptions->first()
        );
    }

    public function can_get_details()
    {
        ProductDetail::factory()->create();

        $this->assertInstanceOf(ProductDetail::class, $this->product->details);
    }

    /** @test */
    public function can_get_details_image()
    {
        $this->product->update([
            'details_img_id' => Image::firstOrFactory()->id
        ]);

        $this->assertInstanceOf(Image::class, $this->product->detailsImage);
    }

    /** @test */
    public function can_get_default_distributor()
    {
        $this->product->update([
            'default_distributor_id' => Distributor::firstOrFactory()->id
        ]);

        $this->assertInstanceOf(
            Distributor::class,
            $this->product->defaultDistributor
        );
    }

    /** @test */
    public function can_get_distributors()
    {
        ProductDistributor::factory(3)->create([
            'product_id' => $this->product->id,
            'distributor_id' => Distributor::factory()
        ]);

        $this->assertCount(3, $this->product->distributors);
        $this->assertInstanceOf(
            Distributor::class,
            $this->product->distributors->first()
        );
    }

    /** @test */
    public function can_get_parent()
    {
        $this->product->update([
            'parent_product' => Product::factory()->create(['parent_product' => null])->id
        ]);

        $this->assertInstanceOf(Product::class, $this->product->parent);
    }

    /** @test */
    public function can_get_children()
    {
        Product::factory(3)->create([
            'parent_product' => $this->product->id
        ]);

        $this->assertCount(3, $this->product->variants);
        $this->assertInstanceOf(Product::class, $this->product->variants->first());
    }

    /** @test */
    public function can_get_accessory_fields()
    {
        ProductAccessoryField::factory(3)->create();

        $this->assertCount(3, $this->product->accessoryFields);
        $this->assertInstanceOf(AccessoryField::class, $this->product->accessoryFields->first());
    }

    /** @todo */
    public function can_get_bookingas()
    {
        BookingAsProduct::factory(3)->create();

        $this->assertCount(3, $this->product->bookingAs);
        $this->assertInstanceOf(BookingAs::class, $this->product->bookingAs->first());
    }

    /** @todo */
    public function can_featured_in_categories()
    {
        CategoryFeaturedProduct::factory(3)->create([
            'category_id' => Category::factory()
        ]);

        $this->assertCount(3, $this->product->featuredInCategories);
        $this->assertInstanceOf(Category::class, $this->product->featuredInCategories->first());
    }

    /** @todo */
    public function can_get_show_in_categories()
    {
        CategoryProductShow::factory(3)->create();

        $this->assertCount(3, $this->product->showInCategories);
        $this->assertInstanceOf(Category::class, $this->product->showInCategories->first());
    }

    /** @todo */
    public function can_get_hide_from_categories()
    {
        CategoryProductHide::factory(3)->create([
            'category_id' => Category::factory()
        ]);

        $this->assertCount(3, $this->product->hideFromCategories);
        $this->assertInstanceOf(Category::class, $this->product->hideFromCategories->first());
    }

    /** @todo */
    public function can_get_custom_forms()
    {
        ProductForm::factory(3)->create();

        $this->assertCount(3, $this->product->customForms);
        $this->assertInstanceOf(CustomForm::class, $this->product->customForms->first());
    }

    /** @todo */
    public function can_get_accessories()
    {
        ProductAccessory::factory(3)
            ->for($this->product)
            ->create();

        $this->product->refresh();

        $this->assertCount(3, $this->product->accessories);
        $this->assertInstanceOf(Product::class, $this->product->accessories->first());
    }

    /** @test */
    public function can_get_options()
    {
        ProductOption::factory(3)->create();

        $this->assertCount(3, $this->product->options);
        $this->assertInstanceOf(ProductOption::class, $this->product->options->first());
    }

    /** @test */
    public function can_get_pricing()
    {
        ProductPricing::factory()->create([
            'status' => true
        ]);
        ProductPricing::factory(2)->create([
            'site_id' => Site::factory(),
            'status' => true
        ]);

        $this->assertCount(3, $this->product->pricing);
        $this->assertInstanceOf(ProductPricing::class, $this->product->pricing->first());

        $site = Site::first();

        $this->assertInstanceOf(
            ProductPricing::class,
            $this->product->pricingBySite($site)
        );

        Config::set('site.id', $site->id);
        $this->assertInstanceOf(
            ProductPricing::class,
            $this->product->pricingForCurrentSite
        );
        $this->assertInstanceOf(
            ProductPricing::class,
            $this->product->pricingForCurrentSite($site->id)->first()
        );
    }

    /** @todo */
    public function can_get_related()
    {
        ProductRelated::factory(3)->create();

        $this->assertCount(3, $this->product->relatedProducts);
        $this->assertInstanceOf(
            Product::class,
            $this->product->relatedProducts->first()
        );
    }

//    /** @test */
//    public function can_get_resort()
//    {
//        ProductResortOLD::factory()->create();
//
//        $this->assertInstanceOf(
//            Resort::class,
//            $this->product->resort
//        );
//    }

    /** @todo */
    public function can_get_reviews()
    {
        ProductReview::factory(3)
            ->for($this->product)
            ->create([
                'item_type' => ProductReviewItemTypes::PRODUCT
            ]);

        $this->assertCount(3, $this->product->reviews);
        $this->assertInstanceOf(
            ProductReview::class,
            $this->product->reviews->first()
        );
    }

    /** @todo */
    public function can_get_settings()
    {
        ProductSettings::factory()
            ->for($this->product)
            ->create();

        $this->assertInstanceOf(
            ProductSettings::class,
            $this->product->settings
        );
    }

    /** @todo */
    public function can_get_template_module_settings()
    {
        $this->product->templateModuleSettings()->create(ProductSettingsTemplateModuleValue::factory());

        $this->assertInstanceOf(
            ProductSettingsTemplateModuleValue::class,
            $this->product->templateModuleSettings
        );
    }

    /** @todo */
    public function can_get_sites_modules_settings()
    {
        $this->product->sitesModuleSettings()->create(ProductSiteSettingsModuleValue::factory());

        $this->assertInstanceOf(ProductSiteSettingsModuleValue::class, $this->product->sitesModuleSettings);
    }

    /** @todo */
    public function can_get_site_settings()
    {
        $this->product->siteSettings()->create(ProductSiteSettings::factory());

        $this->assertInstanceOf(ProductSiteSettings::class, $this->product->sitesSettings);
    }

    /** @todo */
    public function can_get_default_availability()
    {
        $this->assertInstanceOf(
            ProductAvailability::class,
            $this->product->defaultAvailability
        );
    }

    /** @todo */
    public function can_get_brand()
    {
        $this->assertNull($this->product->brand());

        ProductDetail::factory()
            ->for($this->product)
            ->create([
                'brand_id' => Brand::firstOrFactory()->id
            ]);

        $this->assertInstanceOf(Brand::class, $this->product->fresh('details')->brand());
    }

    /** @todo */
    public function can_get_default_category()
    {
        $this->assertNull($this->product->defaultCategory());

        ProductDetail::factory()
            ->for($this->product)
            ->create([
                'default_category_id' => Category::firstOrFactory()->id
            ]);

        $this->assertInstanceOf(Category::class, $this->product->fresh('details')->defaultCategory());
    }

    /** @todo */
    public function can_get_type()
    {
        $this->assertNull($this->product->type());

        ProductDetail::factory()
            ->for($this->product)
            ->create([
                'type_id' => ProductType::firstOrFactory()->id
            ]);

        $this->assertInstanceOf(ProductType::class, $this->product->fresh('details')->type());
    }

    /** @todo */
    public function can_get_is_digital()
    {
        $this->assertFalse($this->product->isDigital());

        ProductDetail::factory()
            ->for($this->product)
            ->create([
                'downloadable' => true
            ]);

        $this->assertTrue($this->product->fresh('details')->isDigital());
    }

    /** @todo */
    public function can_get_fulfillment_rule()
    {

    }
    /** @todo */
    public function can_get_translation()
    {
        ProductTranslation::factory()->create();

        $this->assertInstanceOf(
            ProductTranslation::class,
            $this->product->translations()->first()
        );
    }
}
