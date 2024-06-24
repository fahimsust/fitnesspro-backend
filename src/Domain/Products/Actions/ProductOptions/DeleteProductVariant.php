<?php

namespace Domain\Products\Actions\ProductOptions;

use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductVariantOption;
use Lorisleiva\Actions\Concerns\AsObject;

class DeleteProductVariant
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
        if ($variantProduct->parent_product != $parentProduct->id) {
            throw new \Exception(__("Can't delete: parent product mismatch"));
        }

        $this->updateStockQuantity();
        $this->deleteProductVariantOptions();
        $this->unassignFromParent();


        ConvertVariantIntoIndividualProduct::run($this->variantProduct, $this->parentProduct);
    }

    protected function deleteProductVariantOptions(): void
    {
        ProductVariantOption::where('product_id', $this->variantProduct->id)->delete();
    }

    protected function unassignFromParent(): void
    {
        $this->variantProduct->update(['parent_product' => null]);
    }
    protected function updateStockQuantity(): void
    {
        $this->parentProduct->combined_stock_qty = $this->parentProduct->combined_stock_qty-$this->variantProduct->combined_stock_qty;
        $this->parentProduct->save();
    }

}
