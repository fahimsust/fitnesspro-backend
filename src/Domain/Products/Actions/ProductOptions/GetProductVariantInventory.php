<?php

namespace Domain\Products\Actions\ProductOptions;

use App\Api\Admin\Products\Requests\ProductSearchRequest;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Product;
use Domain\Products\QueryBuilders\ProductOptionValueQuery;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductVariantInventory
{
    use AsObject;

    public function handle(
        Product              $parentProduct,
        ProductSearchRequest $request
    )
    {
        $products = Product::select(
            "products.id",
            "products.product_no",
            "products.combined_stock_qty",
            "products.status",
            "distributors.name as distributor_name",
            DB::raw("GROUP_CONCAT(products_children_options.option_id ORDER BY products_children_options.option_id ASC SEPARATOR ',') as option_ids_string")
        )
            ->joinRelationship('variantOptions')
            ->leftJoinRelationship('defaultDistributor')
            ->whereHas('variantOptions')
            ->where('parent_product', $parentProduct->id)
            ->where('products.status','!=',-1)
            ->search($request)
            ->when(
                $request->filled('order_by'),
                fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
            )
            ->groupBy('products.id')
            ->paginate($request?->per_page);

        $products->getCollection()->transform(function ($product, $key) {
            $optionIds = explode(",", $product->option_ids_string);
            $options = ProductOptionValue::select(
                'products_options.name',
                ProductOptionValueQuery::realDisplaySelect('products_options_values.display'),

            )
                ->joinRelationship('option')
                ->whereIn('products_options_values.id', $optionIds)
                ->get();

            $nameArray = [];

            if ($options) {
                foreach ($options as $value) {
                    $name = $value->name . ": " . $value->real_display;
                    $nameArray[] = $name;
                }
            }

            return [
                'id' => $product->id,
                'sku' => $product->product_no,
                'combined_stock_qty' => $product->combined_stock_qty,
                'status' => $product->status,
                'full_name' => implode(", ", $nameArray),
                'distributor_name' => $product->distributor_name,
            ];
        });

        return $products;
    }

}
