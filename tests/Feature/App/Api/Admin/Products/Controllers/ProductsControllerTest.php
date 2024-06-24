<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use Domain\Discounts\Models\Advantage\AdvantageProduct;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Level\DiscountLevel;
use Domain\Discounts\Models\Level\DiscountLevelProduct;
use Domain\Discounts\Models\Rule\Condition\ConditionProduct;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryFeaturedProduct;
use Domain\Products\Models\Category\CategoryProductHide;
use Domain\Products\Models\Category\CategoryProductShow;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAccessory;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductRelated;
use Domain\Products\Models\Product\ProductType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductsControllerTest extends ControllerTestCase
{
    public Product $product;
    public Brand $brand;
    public ProductType $productType;
    public Collection $products;
    public int $totalProducts = 3;
    public string $keyword;

    protected function setUp(): void
    {
        parent::setUp();

        $this->keyword = "test";
        $this->products = Product::factory($this->totalProducts)->create(['title' => $this->keyword]);

        $parentProduct = $this->products->first();

        $this->products = $this->products->merge(
            Product::factory($this->totalProducts)
                ->create(['title' => $this->keyword, 'parent_product' => $parentProduct->id])
        );

        $this->productType = ProductType::factory()->create();
        $this->brand = Brand::factory()->create();

        $this->createProductDetails();

        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_list_products()
    {
        $this->getJson(route('admin.product.index'))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'title',
                    'subtitle'
                ]
            ]])
            ->assertJsonCount($this->totalProducts * 2, 'data');
    }

    /** @test */
    public function can_filter_to_show_archived_products()
    {
        $this->products->first()->delete();
        $this->getJson(
            route('admin.product.index', ["perPage" => 20, "page" => 1, 'trashed' => 1]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'title',
                    'subtitle'
                ]
            ]])
            ->assertJsonCount(1, 'data');
    }

    /** @test */
    public function can_search_product()
    {
        $response = $this->getJson(
            route('admin.product.index', ["perPage" => 20, "page" => 1, 'keyword' => $this->keyword]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'title',
                    'subtitle'
                ]
            ]])
            ->assertJsonCount($this->totalProducts * 2, 'data');

        $this->assertEquals(1, $response['current_page']);
    }

    /** @test */
    public function can_search_related_product()
    {
        ProductRelated::factory()->create(['product_id' => $this->products[0]->id, 'related_id' => $this->products[1]->id]);
        ProductRelated::factory()->create(['product_id' => $this->products[0]->id, 'related_id' => $this->products[2]->id]);
        $response = $this->getJson(
            route('admin.product.index', ["perPage" => 20, "page" => 1, 'keyword' => $this->keyword, 'product_id' => $this->products[0]->id]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'title',
                    'subtitle'
                ]
            ]])
            ->assertJsonCount(($this->totalProducts * 2) - 3, 'data');
    }
    /** @test */
    public function can_search_accessory_product()
    {
        ProductAccessory::factory()->create(['product_id' => $this->products[0]->id, 'accessory_id' => $this->products[1]->id]);
        ProductAccessory::factory()->create(['product_id' => $this->products[0]->id, 'accessory_id' => $this->products[2]->id]);
        $this->getJson(
            route('admin.product.index', ["perPage" => 20, "page" => 1, 'keyword' => $this->keyword, 'accessory_product_id' => $this->products[0]->id]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'title',
                    'subtitle'
                ]
            ]])
            ->assertJsonCount(($this->totalProducts * 2) - 3, 'data');
    }
    /** @test */
    public function can_search_feature_category_product()
    {
        $category = Category::factory()->create();
        CategoryFeaturedProduct::factory()->create(['product_id' => $this->products[0]->id, 'category_id' => $category->id]);
        CategoryFeaturedProduct::factory()->create(['product_id' => $this->products[1]->id, 'category_id' => $category->id]);
        CategoryFeaturedProduct::factory()->create(['product_id' => $this->products[2]->id, 'category_id' => $category->id]);
        $this->getJson(
            route('admin.product.index', ["perPage" => 20, "page" => 1, 'keyword' => $this->keyword, 'feature_category_id' => $category->id]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'title',
                    'subtitle'
                ]
            ]])
            ->assertJsonCount(($this->totalProducts * 2) - 3, 'data');
    }
    /** @test */
    public function can_search_product_for_hide_category()
    {
        $category = Category::factory()->create();
        CategoryProductHide::factory()->create(['product_id' => $this->products[0]->id, 'category_id' => $category->id]);
        CategoryProductHide::factory()->create(['product_id' => $this->products[1]->id, 'category_id' => $category->id]);
        CategoryProductHide::factory()->create(['product_id' => $this->products[2]->id, 'category_id' => $category->id]);
        $this->getJson(
            route('admin.product.index', ["perPage" => 20, "page" => 1, 'keyword' => $this->keyword, 'product_hide_category_id' => $category->id]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'title',
                    'subtitle'
                ]
            ]])
            ->assertJsonCount(($this->totalProducts * 2) - 3, 'data');
    }
    /** @test */
    public function can_search_product_for_show_category()
    {
        $category = Category::factory()->create();
        CategoryProductShow::factory()->create(['product_id' => $this->products[0]->id, 'category_id' => $category->id]);
        CategoryProductShow::factory()->create(['product_id' => $this->products[1]->id, 'category_id' => $category->id]);
        CategoryProductShow::factory()->create(['product_id' => $this->products[2]->id, 'category_id' => $category->id]);
        $this->getJson(
            route('admin.product.index', ["perPage" => 20, "page" => 1, 'keyword' => $this->keyword, 'product_show_category_id' => $category->id]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'title',
                    'subtitle'
                ]
            ]])
            ->assertJsonCount(($this->totalProducts * 2) - 3, 'data');
    }

    /** @test */
    public function can_search_product_for_discount_condition()
    {
        $discountCondition = DiscountCondition::factory()->create();
        ConditionProduct::factory()->create(['product_id' => $this->products[0]->id, 'condition_id' => $discountCondition->id]);
        ConditionProduct::factory()->create(['product_id' => $this->products[1]->id, 'condition_id' => $discountCondition->id]);
        ConditionProduct::factory()->create(['product_id' => $this->products[2]->id, 'condition_id' => $discountCondition->id]);
        $this->getJson(
            route('admin.product.index', ["perPage" => 20, "page" => 1, 'keyword' => $this->keyword, 'condition_id' => $discountCondition->id]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'title',
                    'subtitle'
                ]
            ]])
            ->assertJsonCount(($this->totalProducts * 2) - 3, 'data');
    }

    /** @test */
    public function can_search_product_for_discount_advantage()
    {
        $discountAdvantage = DiscountAdvantage::factory()->create();
        AdvantageProduct::factory()->create(['product_id' => $this->products[0]->id, 'advantage_id' => $discountAdvantage->id]);
        AdvantageProduct::factory()->create(['product_id' => $this->products[1]->id, 'advantage_id' => $discountAdvantage->id]);
        AdvantageProduct::factory()->create(['product_id' => $this->products[2]->id, 'advantage_id' => $discountAdvantage->id]);
        $this->getJson(
            route('admin.product.index', ["perPage" => 20, "page" => 1, 'keyword' => $this->keyword, 'advantage_id' => $discountAdvantage->id]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'title',
                    'subtitle'
                ]
            ]])
            ->assertJsonCount(($this->totalProducts * 2) - 3, 'data');
    }

    /** @test */
    public function can_search_product_for_discount_level()
    {
        $discountLevel = DiscountLevel::factory()->create();
        DiscountLevelProduct::factory()->create(['product_id' => $this->products[0]->id, 'discount_level_id' => $discountLevel->id]);
        DiscountLevelProduct::factory()->create(['product_id' => $this->products[1]->id, 'discount_level_id' => $discountLevel->id]);
        DiscountLevelProduct::factory()->create(['product_id' => $this->products[2]->id, 'discount_level_id' => $discountLevel->id]);
        $this->getJson(
            route('admin.product.index', ["perPage" => 20, "page" => 1, 'keyword' => $this->keyword, 'discount_level_id' => $discountLevel->id]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'title',
                    'subtitle'
                ]
            ]])
            ->assertJsonCount(($this->totalProducts * 2) - 3, 'data');
    }

    /** @test */
    public function can_hide_child_product()
    {
        $this->getJson(
            route('admin.product.index', ['keyword' => $this->keyword, 'hide_children' => 1]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'title',
                    'subtitle'
                ]
            ]])
            ->assertJsonCount($this->totalProducts, 'data');
    }

    /** @test */
    public function can_search_product_by_brand_and_type()
    {
        $this->getJson(
            route('admin.product.index', ['brand_id' => $this->brand->id, 'type_id' => $this->productType->id]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'title',
                    'subtitle'
                ]
            ]])
            ->assertJsonCount($this->totalProducts * 2, 'data');
    }

    /** @test */
    public function can_get_empty_result_for_brand()
    {
        $brand = Brand::factory()->create();
        $this->getJson(
            route('admin.product.index', [
                'keyword' => $this->keyword,
                'brand_id' => $brand->id,
                'type_id' => $this->productType->id
            ]),
        )
            ->assertJsonStructure(['data' => []])
            ->assertOk();
    }

    /** @test */
    public function can_get_empty_result_for_type()
    {
        $productType = ProductType::factory()->create();
        $this->getJson(
            route('admin.product.index', [
                'keyword' => $this->keyword,
                'brand_id' => $this->brand->id,
                'type_id' => $productType->id
            ]),
        )
            ->assertJsonStructure(['data' => []])
            ->assertOk();
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->getJson(route('admin.product.index', ['brand_id' => 0]))
            ->assertJsonValidationErrorFor('brand_id')
            ->assertStatus(422);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->getJson(route('admin.product.index'), ['brand_id' => $this->brand->id])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }

    private function createProductDetails()
    {
        foreach ($this->products as $product) {
            ProductDetail::factory()->create(['product_id' => $product->id]);
        }
    }
}
