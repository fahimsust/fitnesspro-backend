<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\Products\Requests\CreateProductVariantRequest;
use Domain\Distributors\Models\Distributor;
use Domain\Products\Actions\Distributors\UpdateParentProductCombinedQuantity;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductPricing;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateProductVariant
{
    use AsObject;

    private CreateProductVariantRequest $request;
    private Product $parentProduct;
    private Product $variant;

    public function handle(
        Product                     $parentProduct,
        CreateProductVariantRequest $request
    ): Product
    {
        $this->parentProduct = $parentProduct;
        $this->request = $request;
        $extraUrlName = "";
        $urlName = $parentProduct->url_name . "-" . Str::slug($request->url);
        $numberOfProduct = Product::where('url_name', 'like', $urlName . '%')->count();
        if ($numberOfProduct > 0) {
            $index = $numberOfProduct + 1;
            $extraUrlName = "-" . $index;
        }

        $this->variant = Product::create([
            'title' => $parentProduct->title . " - " . $request->title,
            'url_name' => $parentProduct->url_name . "-" . Str::slug($request->url) . $extraUrlName,
            'product_no' => $request->product_no,
            'inventoried' => $parentProduct->inventoried,
            'parent_product' => $parentProduct->id,
            'weight' => $parentProduct->weight,
            'combined_stock_qty' => $this->request->stock_qty,
            'default_distributor_id' => $parentProduct->default_distributor_id,
            'default_cost' => $parentProduct->default_cost,
            'default_outofstockstatus_id' => $parentProduct->default_outofstockstatus_id,

        ]);

        $this->createDistributorRecords();
        $this->createVariantOptions();
        $this->createPricingRecords();
        UpdateParentProductCombinedQuantity::run($this->variant, $this->request->stock_qty);

        //todo update parent stock

        return $this->variant;
    }

    protected function createDistributorRecords(): void
    {
        $this->variant->productDistributors()->createMany(
            Distributor::select("id")->get()
                ->map(
                    function (Distributor $distributor) {
                        if ($this->variant->default_distributor_id != $distributor->id) {
                            return ['distributor_id' => $distributor->id];
                        }

                        return [
                            'distributor_id' => $distributor->id,
                            'stock_qty' => $this->request->stock_qty
                        ];
                    }
                )
        );
    }

    protected function createVariantOptions(): void
    {
        $this->variant->variantOptions()->createMany(
            array_map(
                fn($optionId) => ['option_id' => $optionId,],
                $this->request->options
            )
        );
    }

    protected function createPricingRecords(): void
    {
        $this->variant->pricing()->createMany(
            $this->parentProduct->pricing()->get()
                ->map(
                    fn(ProductPricing $pricing) => $pricing->replicate()
                        ->fill(['product_id' => $this->variant->id])
                        ->toArray()
                )
        );
    }
}
