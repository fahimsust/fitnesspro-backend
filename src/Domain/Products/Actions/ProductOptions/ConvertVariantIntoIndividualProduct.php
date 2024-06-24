<?php

namespace Domain\Products\Actions\ProductOptions;

use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Products\Models\Product\Settings\ProductSiteSettings;
use Lorisleiva\Actions\Concerns\AsObject;

class ConvertVariantIntoIndividualProduct
{
    use AsObject;

    private Product $parentProduct;
    private Product $variantProduct;

    public function handle(
        Product $variantProduct,
        Product $parentProduct,
    )
    {
        $this->parentProduct = $parentProduct;
        $this->variantProduct = $variantProduct;

        $this->createProductDetails();
        $this->createProductSettings();
        $this->createProductPricing();
    }

    protected function createProductDetails(): void
    {
        $productDetails = ProductDetail::where('product_id', $this->variantProduct->id)->first();
        if ($productDetails) {
            return;
        }

        $this->parentProduct->details->replicate()->fill(
            ['product_id' => $this->variantProduct->id]
        )->save();
    }

    protected function createProductSettings(): void
    {
        $defaultSiteSetting = ProductSiteSettings::where("product_id", $this->variantProduct->id)
            ->where('site_id', null)
            ->first();

        if ($defaultSiteSetting) {
            return;
        }

        $parentSiteSetting = ProductSiteSettings::where("product_id", $this->parentProduct->id)
            ->where('site_id', null)
            ->first();

        if ($parentSiteSetting) {
            $parentSiteSetting->replicate()->fill(
                ['product_id' => $this->variantProduct->id]
            )->save();

            return;
        }

        $this->variantProduct->siteSettings()->create();
    }

    protected function createProductPricing(): void
    {
        if (count($this->variantProduct->pricing) > 0) {
            return;
        }

        $this->variantProduct->pricing()->createMany(
            $this->parentProduct->pricing()->get()
                ->map(
                    fn(ProductPricing $pricing) => $pricing->replicate()
                        ->fill(['product_id' => $this->variantProduct->id])
                        ->toArray()
                )
        );
    }
}
