<?php

namespace Tests\Feature\Domain\Products\Actions\ProductOptions;

use Domain\Products\Actions\ProductOptions\CreateVariantsFromUnassignedOptionValues;
use Domain\Products\Actions\ProductOptions\CreateVariantsWithOptionValueIds;
use Domain\Products\Actions\ProductOptions\GetCombosAwaitingVariant;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Product;
use Tests\Feature\Traits\TestProductUtilities;
use Tests\TestCase;

class GetCombosAwaitingVariantTest extends TestCase
{
    use TestProductUtilities;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createProductWithOptionValues();
    }

    /** @test */
    public function all_awaiting()
    {
        $this->assertDatabaseCount(Product::Table(), 1);

        $this->assertCount(
            4,
            GetCombosAwaitingVariant::run($this->product)
        );
    }

    /** @test */
    public function some_waiting()
    {
        //creating one combo variant
        CreateVariantsWithOptionValueIds::run(
            $this->product,
            GetCombosAwaitingVariant::run($this->product)->take(1)
        );

        $this->assertDatabaseCount(Product::Table(), 2);

        $awaitingCombos = GetCombosAwaitingVariant::run($this->product);
        $this->assertCount(3, $awaitingCombos);
    }

    /** @test */
    public function none_waiting()
    {
        CreateVariantsWithOptionValueIds::run(
            $this->product,
            GetCombosAwaitingVariant::run($this->product)
        );

        $this->assertCount(
            0,
            $awaitingCombos = GetCombosAwaitingVariant::run($this->product)
        );
    }
}
