<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;


use App\Api\Admin\Products\Requests\ProductSiteSettingsRequest;
use Domain\Products\Actions\Product\UpdateProductSiteSettings;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\Settings\ProductSiteSettings;
use Domain\Sites\Models\Layout\DisplayTemplate;
use Domain\Sites\Models\Layout\DisplayTemplateType;
use Domain\Sites\Models\Layout\Layout;
use Domain\Sites\Models\Site;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductSiteSettingsControllerTest extends ControllerTestCase
{
    public Product $product;
    private Site $site;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
        $this->product = Product::factory()->create();
        $this->site = Site::factory()->create(['id' => config('site.id')]);
    }

    /** @test */
    public function get_product_site_settings()
    {
        ProductSiteSettings::factory()->create(['site_id'=>null,'product_id'=>$this->product->id]);
        Site::factory()->create();

        $this->getJson(route('admin.product.site-setting.index', $this->product))
        ->assertOk()
        ->assertJsonStructure(['*'=>['site_id', 'name','settings']])
        ->assertJsonCount(3);
    }

    /** @test */
    public function can_create_new_site_settings()
    {
        ProductSiteSettingsRequest::fake();

        $this->postJson(route('admin.product.site-setting.store', $this->product))
            ->assertCreated()
            ->assertJsonStructure(['site_id', 'product_id']);

        $this->assertDatabaseCount(ProductSiteSettings::Table(), 1);
        $this->assertEquals($this->product->id, ProductSiteSettings::first()->product_id);
        $this->assertEquals($this->site->id, ProductSiteSettings::first()->site_id);
    }

    /** @test */
    public function can_update_site_settings()
    {
        $layout_id = Layout::factory()->create()->id;

        $productSiteSettings = ProductSiteSettings::factory(['site_id' => $this->site->id])->create();
        ProductSiteSettingsRequest::fake(['layout_id' => $layout_id]);

        $this->postJson(route('admin.product.site-setting.store', $this->product))
            ->assertCreated()
            ->assertJsonStructure(['site_id', 'product_id'])
            ->assertJsonFragment([
                'site_id' => $this->site->id,
                'product_id' => $productSiteSettings->product_id,
                'layout_id' => $layout_id
            ]);
    }

    /** @test */
    public function can_update_site_settings_without_site()
    {
        $layout_id = Layout::factory()->create()->id;
        $productSiteSetting = ProductSiteSettings::factory(['site_id' => null])->create();

        ProductSiteSettingsRequest::fake(['layout_id' => $layout_id, 'site_id' => null]);

        $this->postJson(route('admin.product.site-setting.store', $this->product))
            ->assertCreated()
            ->assertJsonStructure(['site_id', 'product_id'])
            ->assertJsonFragment([
                'site_id' => null,
                'product_id' => $productSiteSetting->product_id,
                'layout_id' => $layout_id
            ]);
    }
    /** @test */
    public function no_validation_error_for_value_null()
    {
        ProductSiteSettingsRequest::fake(['settings_template_id_default'=>null,'settings_template_id' => null]);

        $this->postJson(route('admin.product.site-setting.store', $this->product))
            ->assertCreated()
            ->assertJsonStructure(['site_id', 'product_id']);

        $this->assertDatabaseCount(ProductSiteSettings::Table(), 1);
    }
    /** @test */
    public function validation_error_for_value_one()
    {
        ProductSiteSettingsRequest::fake(['settings_template_id_default'=>1,'settings_template_id' => null]);

        $this->postJson(route('admin.product.site-setting.store', $this->product))
            ->assertJsonValidationErrorFor('settings_template_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(ProductSiteSettings::Table(), 0);
    }
    /** @test */
    public function validation_error_for_wrong_display_template()
    {
        $displayTemplateType = DisplayTemplateType::factory()->create(['id'=>10]);
        $displayTemplate = DisplayTemplate::factory()->create(['type_id'=>$displayTemplateType->id]);
        ProductSiteSettingsRequest::fake(['product_detail_template' => $displayTemplate->id]);

        $this->postJson(route('admin.product.site-setting.store', $this->product))
            ->assertJsonValidationErrorFor('product_detail_template')
            ->assertStatus(422);

        $this->assertDatabaseCount(ProductSiteSettings::Table(), 0);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        ProductSiteSettingsRequest::fake(['module_template_id' => 0]);

        $this->postJson(route('admin.product.site-setting.store', $this->product))
            ->assertJsonValidationErrorFor('module_template_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(ProductSiteSettings::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(UpdateProductSiteSettings::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        ProductSiteSettingsRequest::fake();

        $this->postJson(route('admin.product.site-setting.store', $this->product))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test"]);

        $this->assertDatabaseCount(ProductSiteSettings::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        ProductSiteSettingsRequest::fake();

        $this->postJson(route('admin.product.site-setting.store', $this->product))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ProductSiteSettings::Table(), 0);
    }
}
