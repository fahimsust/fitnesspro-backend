<?php

namespace Tests\Feature\Domain\Products\Actions\ProductOptions;

use Domain\Products\Actions\ProductOptions\CreateVariantsFromUnassignedOptionValues;
use Domain\Products\Actions\ProductOptions\CreateVariantsWithOptionValueIds;
use Domain\Products\Actions\ProductOptions\GetCombosAwaitingVariant;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Product;
use Tests\Feature\Traits\TestProductUtilities;
use Tests\TestCase;

class CreateVariantsFromUnassignedOptionValuesTest extends TestCase
{
    use TestProductUtilities;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createProductWithOptionValues();
    }

    /** @test */
    public function can_create_all()
    {
        $this->assertDatabaseCount(Product::Table(), 1);

        $newVariants = CreateVariantsFromUnassignedOptionValues::run($this->product);

        $this->assertCount(4, $newVariants);
        $this->assertInstanceOf(Product::class, $newVariants->first());
        $this->assertEquals($this->product->id, $newVariants->first()->parent_product);

        $this->assertDatabaseCount(Product::Table(), 5);
    }

    /** @test */
    public function can_create_some()
    {
        //creating one combo variant
        CreateVariantsWithOptionValueIds::run(
            $this->product,
            GetCombosAwaitingVariant::run($this->product)->take(1)
        );

        $this->assertDatabaseCount(Product::Table(), 2);

        $newVariants = CreateVariantsFromUnassignedOptionValues::run($this->product);

        $this->assertCount(3, $newVariants);
        $this->assertInstanceOf(Product::class, $newVariants->first());
        $this->assertEquals($this->product->id, $newVariants->first()->parent_product);

        $this->assertDatabaseCount(Product::Table(), 5);
    }

    /** @test */
    public function will_ignore_if_no_combos_waiting()
    {
        CreateVariantsWithOptionValueIds::run(
            $this->product,
            GetCombosAwaitingVariant::run($this->product)
        );

        $this->assertDatabaseCount(Product::Table(), 5);

        $this->assertNull(CreateVariantsFromUnassignedOptionValues::run($this->product));

        $this->assertDatabaseCount(Product::Table(), 5);
    }
}
