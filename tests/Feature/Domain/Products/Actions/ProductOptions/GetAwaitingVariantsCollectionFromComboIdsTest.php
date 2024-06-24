<?php

namespace Tests\Feature\Domain\Products\Actions\ProductOptions;

use Domain\Products\Actions\ProductOptions\CreateVariantsWithOptionValueIds;
use Domain\Products\Actions\ProductOptions\GetAwaitingVariantsCollectionFromComboIds;
use Domain\Products\Actions\ProductOptions\GetCombosAwaitingVariant;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Product;
use Domain\Products\ValueObjects\AwaitingVariantOptionValuesComboVo;
use Tests\Feature\Traits\TestProductUtilities;
use Tests\TestCase;

class GetAwaitingVariantsCollectionFromComboIdsTest extends TestCase
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

        $this->assertCount(4, $optionValues = GetAwaitingVariantsCollectionFromComboIds::run(
                GetCombosAwaitingVariant::run($this->product)
            )
        );

        $this->assertInstanceOf(AwaitingVariantOptionValuesComboVo::class, $optionValues->first());
        $this->assertCount(2, $optionValues->first()->productOptionValues);
        //$this->assertInstanceOf(ProductOption::class, $optionValues->first()->productOptionValues->first()->option);
    }
}
