<?php

namespace Domain\Products\QueryBuilders;

use App\Api\Admin\Products\Requests\ProductSearchRequest;
use Domain\Discounts\Models\Advantage\AdvantageProduct;
use Domain\Discounts\Models\Level\DiscountLevelProduct;
use Domain\Discounts\Models\Rule\Condition\ConditionProduct;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductQuery extends Builder
{
    public function useAliasDeletedAt(): static
    {
        //need to set our own deleted_at check
        $this
            ->withTrashed()
            ->whereNull('p.deleted_at');

        return $this;
    }

    public function basicKeywordSearch(?string $keyword = null): static
    {
        $this->like(['products.id', 'products.title'], $keyword);

        return $this;
    }

    public function searchForRelatedProduct(ProductSearchRequest $request, $product)
    {
        $request
            ->whenFilled(
                'keyword',
                fn () => $this->basicKeywordSearch($request->keyword) && false
            );

        return $this;
    }

    public function forParentProduct(int $productId)
    {
        return $this->whereParentProduct($productId);
    }

    public function search(ProductSearchRequest $request): static
    {
        $request
            ->whenFilled(
                'keyword',
                fn () => $this->basicKeywordSearch($request->keyword) && false
            )
            ->whenFilled(
                'trashed',
                fn () => $this->onlyTrashed() && false
            )
            ->whenFilled(
                'hide_children',
                fn () => $this->whereNull('parent_product') && false
            );

        if ($request->anyFilled(['type_id', 'brand_id'])) {
            $this->whereHas(
                'details',
                fn (Builder $query) => $request
                    ->whenFilled(
                        'type_id',
                        fn () => $query->whereTypeId($request->type_id) && false
                    )
                    ->whenFilled(
                        'brand_id',
                        fn () => $query->whereBrandId($request->brand_id) && false
                    )
            );
        }
        if ($request->filled('product_id')) {
            $related_product_ids = Product::find($request->product_id)->relatedProducts->pluck('id')->toArray();
            if ($related_product_ids)
                $this->whereNotIn('id', $related_product_ids);

            $this->where('id', '!=', $request->product_id);
        }
        if ($request->filled('accessory_product_id')) {
            $accessory_ids = Product::find($request->accessory_product_id)->productAccessories->pluck('accessory_id')->toArray();
            if ($accessory_ids)
                $this->whereNotIn('id', $accessory_ids);

            $this->where('id', '!=', $request->accessory_product_id);
        }
        if ($request->filled('feature_category_id')) {
            $product_ids = Category::find($request->feature_category_id)->categoryFeaturedProducts->pluck('product_id')->toArray();
            if ($product_ids)
                $this->whereNotIn('id', $product_ids);
        }
        if ($request->filled('product_show_category_id')) {
            $product_ids = Category::find($request->product_show_category_id)->categoryProductShows->pluck('product_id')->toArray();
            if ($product_ids)
                $this->whereNotIn('id', $product_ids);
        }
        if ($request->filled('product_hide_category_id')) {
            $product_ids = Category::find($request->product_hide_category_id)->categoryProductHides->pluck('product_id')->toArray();
            if ($product_ids)
                $this->whereNotIn('id', $product_ids);
        }
        if ($request->filled('advantage_id')) {
            $product_ids = AdvantageProduct::whereAdvantageId($request->advantage_id)->get()->pluck('product_id')->toArray();
            if ($product_ids)
                $this->whereNotIn('id', $product_ids);
        }
        if ($request->filled('discount_level_id')) {
            $product_ids = DiscountLevelProduct::whereDiscountLevelId($request->discount_level_id)->get()->pluck('product_id')->toArray();
            if ($product_ids)
                $this->whereNotIn('id', $product_ids);
        }
        // if ($request->filled('order_id')) {
        //     $product_ids = OrderItem::whereOrderId($request->order_id)->get()->pluck('product_id')->toArray();
        //     if($product_ids)
        //         $this->whereNotIn('id',$product_ids);
        // }
        if ($request->filled('condition_id')) {
            $product_ids = ConditionProduct::whereConditionId($request->condition_id)->get()->pluck('product_id')->toArray();
            if ($product_ids)
                $this->whereNotIn('id', $product_ids);
        }

        return $this;
    }
}
