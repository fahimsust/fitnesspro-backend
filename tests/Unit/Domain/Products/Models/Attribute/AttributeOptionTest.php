<?php

namespace Tests\Unit\Domain\Products\Models\Attribute;

use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Attribute\AttributeOptionTranslation;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\Rule\CategoryRule;
use Domain\Products\Models\Category\Rule\CategoryRuleAttribute;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAttribute;
use Tests\UnitTestCase;

class AttributeOptionTest extends UnitTestCase
{
    private AttributeOption $attributeOption;

    protected function setUp(): void
    {
        parent::setUp();
        $this->attributeOption = AttributeOption::factory()->create();
    }

    /** @test */
    public function can_get_products()
    {
        ProductAttribute::factory()->create();
        $this->assertInstanceOf(Product::class, $this->attributeOption->products()->first());
    }

    /** @test */
    public function can_get_translation()
    {
        AttributeOptionTranslation::factory()->create();
        $this->assertInstanceOf(AttributeOptionTranslation::class, $this->attributeOption->translations()->first());
    }

    /** @test */
    public function get_categories()
    {
        $categoryRuleAttributes = CategoryRuleAttribute::factory(3)
            ->sequence(
                fn() => [
                    'rule_id' => CategoryRule::factory()
                        ->create([
                            'category_id' => Category::factory()->create()->id,
                        ])->id,
                ]
            )
            ->create([
                'value_id' => $this->attributeOption->id,
            ]);

        $this->assertCount(3, $this->attributeOption->categories);
        $this->assertInstanceOf(Category::class, $this->attributeOption->categories->first());
    }
}
