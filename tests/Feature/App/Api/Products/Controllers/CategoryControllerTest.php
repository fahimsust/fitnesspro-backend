<?php

namespace Tests\Feature\App\Api\Products\Controllers;

use Database\Seeders\ProductAvailabilitySeeder;
use Domain\Content\Models\Image;
use Domain\Products\Actions\ProductOptions\CreateVariantsFromUnassignedOptionValues;
use Domain\Products\Enums\FilterTypes;
use Domain\Products\Enums\ProductOptionTypes;
use Domain\Products\Enums\ShowProductsOptions;
use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryFeaturedProduct;
use Domain\Products\Models\Category\CategoryProductShow;
use Domain\Products\Models\Category\CategorySettings;
use Domain\Products\Models\Filters\Filter;
use Domain\Products\Models\Filters\FilterAvailability;
use Domain\Products\Models\Filters\FilterPricing;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAttribute;
use Domain\Products\Models\Product\ProductAvailability;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Products\Models\Product\ProductType;
use Domain\Products\Models\Product\Settings\ProductSiteSettings;
use Domain\Sites\Models\Site;
use Illuminate\Support\Collection;
use Tests\TestCase;
use function route;

class CategoryControllerTest extends TestCase
{
    private Category $category;
    private Collection $subcategories;
    private Site $site;
    private Collection $styleOptionValues;
    private ProductOption $styleOption;
    private Collection $filters;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ProductAvailabilitySeeder::class);

        $this->site = Site::factory()->create();

        $this->category = Category::factory()->create([
            'url_name' => 'test-category',
            'status' => true
        ]);

        $this->subcategories = Category::factory(3)
            ->for($this->category, 'parent')
            ->create([
                'status' => true
            ]);

        CategorySettings::factory()
            ->for($this->category)
            ->create([
                'show_featured' => 1,
                'show_products' => ShowProductsOptions::UseManuallyRelatedProducts,
            ]);

        $productTypes = ProductType::factory(3)
            ->create();
        $brands = Brand::factory(3)
            ->create();

        $attributes = Attribute::factory(3)
            ->sequence(
                ['name' => 'Hue'],
                ['name' => 'General Size'],
                ['name' => 'Material'],
            )
            ->create();

        $colorAttributes = AttributeOption::factory(3)
            ->for($colorAttribute = $attributes->first())
            ->sequence(
                ['display' => 'Red'],
                ['display' => 'Blue'],
                ['display' => 'Green'],
            )
            ->create();

        $sizeAttributes = AttributeOption::factory(3)
            ->for($sizeAttribute = $attributes->get(1))
            ->sequence(
                ['display' => 'Small'],
                ['display' => 'Medium'],
                ['display' => 'Large'],
            )
            ->create();

        $materialAttributes = AttributeOption::factory(3)
            ->for($materialAttribute = $attributes->get(2))
            ->sequence(
                ['display' => 'Cotton'],
                ['display' => 'Polyester'],
                ['display' => 'Wool'],
            )
            ->create();

        $this->filters = Filter::factory(8)
            ->sequence(
                [
                    'type' => FilterTypes::Availability,
                    'name' => 'avail',
                    'label' => 'Availability',
                ],
                [
                    'type' => FilterTypes::Price,
                    'name' => 'price',
                    'label' => 'Price',
                ],
                [
                    'type' => FilterTypes::Brand,
                    'name' => 'brand',
                    'label' => 'Brand'
                ],
                [
                    'type' => FilterTypes::Type,
                    'name' => 'type',
                    'label' => 'Type'
                ],
                [
                    'type' => FilterTypes::Attribute,
                    'name' => 'attribute',
                    'label' => 'Attributes'
                ],
                [
                    'type' => FilterTypes::Option,
                    'name' => 'Size Option',
                ],
                [
                    'type' => FilterTypes::Option,
                    'name' => 'Style Option',
                ],
                [
                    'type' => FilterTypes::Option,
                    'name' => 'Date Option',
                ],
            )
            ->create();

        $categoryFilters = $this->category->categoryFilters()
            ->createMany(
                $this->filters->map(
                    fn(Filter $filter) => [
                        'filter_id' => $filter->id,
                    ]
                )
            );

        $products = Product::factory(12)
            ->create([
                'status' => 1,
                'parent_product' => null,
                'category_img_id' => Image::factory()->create()->id,
            ]);

        $firstProduct = $products->first();
        $this->styleOption = ProductOption::factory()
            ->for($firstProduct)
            ->create([
                'type_id' => ProductOptionTypes::Select,
                'status' => true,
                'rank' => 1,
                'name' => 'Style',
                'display' => 'Style',
            ]);

        $this->styleOptionValues = ProductOptionValue::factory(3)
            ->for($this->styleOption, 'option')
            ->sequence([
                'name' => 'Fancy',
                'display' => 'Fancy',
                'rank' => 1,
            ], [
                'name' => 'Lame',
                'display' => 'Lame',
                'rank' => 2,
            ], [
                'name' => 'Silly',
                'display' => 'Silly',
                'rank' => 3,
            ])
            ->create([
                'status' => true,
            ]);

        $dateOption = ProductOption::factory()
            ->for($firstProduct)
            ->create([
                'type_id' => ProductOptionTypes::DateRange,
                'status' => true,
                'rank' => 1,
                'name' => 'Date',
                'display' => 'Date',
            ]);
        ProductOptionValue::factory(2)
            ->for($dateOption, 'option')
            ->sequence([
                'name' => ($name =
                    ($startDate = now())->toDateString()
                    . ' to '
                    . ($endDate = $startDate->clone()->addDays(1))->toDateString()
                ),
                'display' => $name,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'rank' => 1,
            ], [
                'name' => (
                $name = ($startDate = now()->addDays(2))->toDateString()
                    . ' to '
                    . ($endDate = $startDate->clone()->addDays(1))->toDateString()
                ),
                'display' => $name,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'rank' => 2,
            ])
            ->create([
                'status' => true,
            ]);

        $firstProduct->update([
            'has_children' => true,
        ]);

        CreateVariantsFromUnassignedOptionValues::run($firstProduct)
            ->each(
                fn(Product $product) => $product->update([
                        'status' => true
                    ])
                    && ProductPricing::factory()
                        ->for($product)
                        ->create([
                            'site_id' => $this->site->id,
                            'status' => 1
                        ])
            );

        $lastProduct = $products->last();
        $sizeOption = ProductOption::factory()
            ->for($lastProduct)
            ->create([
                'type_id' => ProductOptionTypes::Select,
                'status' => true,
                'rank' => 1,
                'name' => 'Size',
                'display' => 'Size',
            ]);

        ProductOptionValue::factory(3)
            ->for($sizeOption, 'option')
            ->sequence(
                ['name' => '1', 'display' => '1', 'rank' => 1],
                ['name' => '2', 'display' => '2', 'rank' => 2],
                ['name' => '3', 'display' => '3', 'rank' => 3],
            )
            ->create([
                'status' => true,
            ]);

        $lastProduct->update([
            'has_children' => true,
        ]);
        CreateVariantsFromUnassignedOptionValues::run($lastProduct)
            ->each(
                fn(Product $product) => $product->update([
                        'status' => true
                    ])
                    && ProductPricing::factory()
                        ->for($product)
                        ->create([
                            'site_id' => $this->site->id,
                            'status' => 1
                        ])
            );

        $this->filters
            ->each(
                fn(Filter $filter) => match ($filter->type) {
                    FilterTypes::Availability => $filter->filterAvailabilities()
                        ->createMany([
                            [
                                'avail_ids' => '1,5',
                                'label' => 'In Stock',
                                'rank' => 1,
                                'status' => true
                            ],
                            [
                                'avail_ids' => '2,3,4',
                                'label' => 'Out of Stock',
                                'rank' => 2,
                                'status' => true
                            ],
                        ]),
                    FilterTypes::Price => $filter->pricing()
                        ->createMany([
                            [
                                'label' => 'Under $100',
                                'price_min' => 0,
                                'price_max' => 99.99,
                                'rank' => 1,
                                'status' => true
                            ],
                            [
                                'label' => 'Over $100',
                                'price_min' => 100,
                                'price_max' => null,
                                'rank' => 2,
                                'status' => true
                            ]
                        ]),
                    FilterTypes::Attribute => $filter->filterAttributes()
                        ->createMany([
                            [
                                'attribute_id' => $colorAttribute->id,
                                'label' => $colorAttribute->name,
                                'status' => true
                            ],
                            [
                                'attribute_id' => $sizeAttribute->id,
                                'label' => $sizeAttribute->name,
                                'status' => true
                            ],
                            [
                                'attribute_id' => $materialAttribute->id,
                                'label' => $materialAttribute->name,
                                'status' => true
                            ],
                        ]),
                    FilterTypes::Option => $filter
                        ->productOptions()
                        ->create(
                            match ($filter->name) {
                                'Style Option' => [
                                    'option_name' => $this->styleOption->name,
                                    'label' => $this->styleOption->name,
                                    'status' => true,
                                    'rank' => 1,
                                ],
                                'Date Option' => [
                                    'option_name' => $dateOption->name,
                                    'label' => $dateOption->name,
                                    'status' => true,
                                    'rank' => 2,
                                ],
                                'Size Option' => [
                                    'option_name' => $sizeOption->name,
                                    'label' => $sizeOption->name,
                                    'status' => true,
                                    'rank' => 3,
                                ]
                            }
                        ),
                    default => null,
                }
            );

        $products
            ->each(
                fn(Product $product) => $product->setRelation(
                    'details',
                    ProductDetail::factory()
                        ->for($product)
                        ->create([
                            'default_category_id' => $this->category->id,
                            'brand_id' => $brands->random()->id,
                            'type_id' => $productTypes->random()->id,
                        ])
                )
            )
            ->each(
                function (Product $product)
                use ($colorAttributes, $sizeAttributes, $materialAttributes) {
                    $options = collect([
                        $colorAttributes->random()->id,
                        $sizeAttributes->random()->id,
                        $materialAttributes->random()->id,
                    ]);

                    $product->productAttributes()
                        ->createMany(
                            $options
                                ->map(
                                    fn($id) => ['option_id' => $id]
                                )
                                ->toArray()
                        );

                    $product->details()
                        ->update(['attributes' => $options->toArray()]);
                }
            )
            ->each(
                fn(Product $product) => CategoryProductShow::factory()
                    ->for($this->category)
                    ->for($product)
                    ->create([
                        'manual' => 1
                    ])
            )
            ->each(
                fn(Product $product) => ProductPricing::factory()
                    ->for($product)
                    ->create([
                        'site_id' => $this->site->id,
                        'status' => 1
                    ])
            )
            ->each(
                fn(Product $product) => ProductSiteSettings::factory()
                    ->for($product)
                    ->create([
                        'site_id' => $this->site->id,
                    ])
            );

        CategoryFeaturedProduct::factory(3)
            ->for($this->category)
            ->sequence(
                ['product_id' => $products->first()->id],
                ['product_id' => $products->get(1)->id],
                ['product_id' => $products->get(2)->id],
            )
            ->create();
    }

    /** @test */
    public function can()
    {
        $response = $this->postJson(
            route(
                'category.index',
                ['category_slug' => $this->category->url_name]
            ),
            [
                'include' => [
                    'category',
                    'categories',
                    'filters',
                    'products',
                    'featured_products',
                ],
                'page' => 1,
                'per_page' => 10,
            ])
            ->assertOk()
            ->assertJsonStructure([
                'filters' => [
                    '*' => [
                        'filter',
                        'fields'
                    ]
                ],
                'featured_products',
                'products' => [
                    'data' => [
                        '*' => [
                            'id',
                            'parent_product',
                            'title',
                            'subtitle',
                            'status',
                            'summary',
                            'description',
                            'availability_id',
                            'details_img_id',
                            'category_img_id',
                            'product_no',
                            'stock_qty',
                            'inventoried',
                            'published_date',
                            'site_id',
                            'min_qty',
                            'max_qty',
                            'rating',
                            'url_name',
                            'has_options',
                            'brand_name',
                            'price_reg',
                            'price_sale',
                            'use_site_settings' => [
                                'id',
                                'product_id',
                                'site_id',
                                'product_thumbnail_template',
                            ],
                            'thumbnail_image' => [
                                'id',
                                'filename',
                                'default_caption',
                                'name',
                                'url'
                            ],
                        ]
                    ]
                ],
                'subcategories' => [
                    '*' => [
                        'id',
                        'title',
                        'slug',
                    ]
                ],
                'category' => [
                    'id',
                    'title',
                    'slug',
                ],
            ]);

        $this->assertCount(10, $response->json('products.data'));
//        dd($response->json('filters'));
        $this->assertCount(3, $response->json('featured_products.data'));
    }

    /** @test */
    public function can_paginate()
    {
        $response = $this->postJson(
            route(
                'category.index',
                ['category_slug' => $this->category->url_name]
            ),
            [
                'include' => [
                    'products',
                ],
                'page' => 2,
                'per_page' => 10,
            ])
            ->assertOk();

        $this->assertCount(2, $response->json('products.data'));
    }

    /** @test */
    public function can_option_filter()
    {
        $this->performFilterPost(
            [
                'option_filter' => [
                    $this->filters
                        ->firstWhere(
                            'name',
                            'Style Option'
                        )->id => [$this->styleOptionValues->first()->id],
                ]
            ],
            1
        );
    }

    /** @test */
    public function can_attribute_filter()
    {
        $firstProductAttribute = ProductAttribute::with('attributeOption')->first();

        $this->performFilterPost(
            [
                'att_filter' => [
                    $firstProductAttribute->attributeOption->attribute_id => [
                        $firstProductAttribute->option_id
                    ]
                ]
            ],
            Product::query()
                ->whereHas(
                    'details',
                    fn($query) => $query
                        ->whereJsonContains(
                            'attributes',
                            $firstProductAttribute->option_id
                        )
                )
                ->whereNull('parent_product')
                ->count()
        );
    }

    /** @test */
    public function can_brand_filter()
    {
        $firstBrand = ProductDetail::first();

        $this->performFilterPost(
            [
                'brand_filter' => [$firstBrand->brand_id]
            ],
            Product::query()
                ->whereHas(
                    'details',
                    fn($query) => $query
                        ->where(
                            'brand_id',
                            $firstBrand->brand_id
                        )
                )
                ->whereNull('parent_product')
                ->count()
        );
    }

    /** @test */
    public function can_type_filter()
    {
        ProductDetail::query()
            ->take(6)
            ->update([
                'type_id' => $typeId = ProductType::factory()->create()->id
            ]);

        $this->performFilterPost(
            [
                'type_filter' => [$typeId]
            ],
            Product::query()
                ->whereHas(
                    'details',
                    fn($query) => $query
                        ->where(
                            'type_id',
                            $typeId
                        )
                )
                ->whereNull('parent_product')
                ->count()
        );
    }

    /** @test */
    public function can_price_filter()
    {
        $firstPricing = FilterPricing::first();

        $this->performFilterPost(
            [
                'price_filter' => [$firstPricing->id]
            ],
            Product::query()
                ->where(
                    fn($query) => $query
                        ->whereHas(
                            'pricing',
                            fn($query) => $query
                                ->where(
                                    'site_id',
                                    $this->site->id
                                )
                                ->where(
                                    \DB::raw('IF(onsale > 0, price_sale, price_reg)'),
                                    '>=',
                                    $firstPricing->price_min
                                )
                                ->where(
                                    \DB::raw('IF(onsale > 0, price_sale, price_reg)'),
                                    '<=',
                                    $firstPricing->price_max
                                )
                        )
                        ->orWhereHas(
                            'variants.pricing',
                            fn($query) => $query
                                ->where(
                                    'site_id',
                                    $this->site->id
                                )
                                ->where(
                                    \DB::raw('IF(onsale > 0, price_sale, price_reg)'),
                                    '>=',
                                    $firstPricing->price_min
                                )
                                ->where(
                                    \DB::raw('IF(onsale > 0, price_sale, price_reg)'),
                                    '<=',
                                    $firstPricing->price_max
                                )
                        )
                )
                ->whereNull('parent_product')
                ->count()
        );
    }

    /** @test */
    public function can_avail_filter()
    {
        $firstAvailability = FilterAvailability::first();
        $availabilityIds = explode("|", $firstAvailability->avail_ids);

        Product::query()
            ->update([
                'default_outofstockstatus_id' => 2,
            ]);

        Product::query()
            ->where('has_children', 0)
            ->take(6)
            ->update([
                'combined_stock_qty' => 0
            ]);

        $query = Product::query()
            ->select('p.id')
            ->fromRaw(Product::Table() . ' p')
            ->useAliasDeletedAt()
            ->join(
                \DB::raw(ProductAvailability::Table() . ' pa'),
                'p.default_outofstockstatus_id',
                '=',
                'pa.id'
            )
            ->leftJoin(
                \DB::raw(ProductAvailability::Table() . ' pac'),
                fn($join) => $join
                    ->whereRaw('p.inventoried = 1')
                    ->whereRaw('pac.auto_adjust = 1')
                    ->where(
                        fn($query) => $query
                            ->whereRaw('p.combined_stock_qty >= pac.qty_min')
                            ->orWhereNull('pac.qty_min')
                    )
                    ->where(
                        fn($query) => $query
                            ->whereRaw('p.combined_stock_qty <= pac.qty_max')
                            ->orWhereNull('pac.qty_max')
                    )
            )
            ->leftJoin(
                \DB::raw(Product::Table() . ' cp'),
                'p.id',
                '=',
                'cp.parent_product'
            )
            ->leftJoin(
                \DB::raw(ProductAvailability::Table() . ' childpa'),
                fn($join) => $join
                    ->whereRaw('p.has_children = 1')
                    ->on('childpa.id', '=', 'cp.default_outofstockstatus_id')
            )
            ->leftJoin(
                \DB::raw(ProductAvailability::Table() . ' childpac'),
                fn($join) => $join
                    ->whereRaw('p.has_children = 1')
                    ->whereRaw('cp.inventoried = 1')
                    ->whereRaw('childpac.auto_adjust = 1')
                    ->where(
                        fn($query) => $query
                            ->whereRaw('cp.combined_stock_qty >= childpac.qty_min')
                            ->orWhereNull('childpac.qty_min')
                    )
                    ->where(
                        fn($query) => $query
                            ->whereRaw('cp.combined_stock_qty <= childpac.qty_max')
                            ->orWhereNull('childpac.qty_max')
                    )
            )
            ->whereNull('p.parent_product')
            ->where(
                fn($query) => $query
                    ->whereRaw(
                        'IF(pac.id = 2, pa.id, pac.id) IN (' . implode(",", $availabilityIds) . ')'
                    )
                    ->orWhereRaw(
                        'IF(childpac.id = 2, childpa.id, childpac.id) IN (' . implode(",", $availabilityIds) . ')'
                    )
            )
            ->groupBy('p.id');

//        dump(
//            $query->count(),
//            $query->toRawSql(),
//            $query->get()->toArray()
//        );

        $this->performFilterPost(
            [
                'avail_filter' => [$firstAvailability->id]
            ],
            $query->count()
        );
    }

    protected function performFilterPost(
        array $filterData,
        int   $expectedCount
    )
    {
        $response = $this->postJson(
            route(
                'category.index',
                ['category_slug' => $this->category->url_name]
            ),
            [
                'include' => [
                    'products',
                ],
                'page' => 1,
                'per_page' => 10,
            ] + $filterData
        )
            ->assertOk();

//        dd($response->json('products.data'));

        $this->assertCount($expectedCount, $response->json('products.data'));
    }
}
