<?php

namespace Domain\Content\QueryBuilders;

use App\Api\Support\Requests\ImageSearchRequest;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductImage;
use GuzzleHttp\Promise\Is;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class ImageQuery extends Builder
{

    public function basicKeywordSearch(?string $keyword = null): static
    {
        $this->like(['name'], $keyword);

        return $this;
    }

    public function search(ImageSearchRequest $request): static
    {
        $request
            ->whenFilled(
                'keyword',
                fn () => $this->basicKeywordSearch($request->keyword) && false
            );
        if ($request->filled('product_id')) {
            $product = Product::findOrFail($request->product_id);
            $imageInBool = false;
            if($product->parent_product)
            {
                $imageInBool = true;
                $imageIn = ProductImage::whereProductId($product->parent_product)->pluck('image_id')->toArray();
            }
            $imageNotIn = ProductImage::whereProductId($product->id)->pluck('image_id')->toArray();

            if($imageInBool)
               $this->whereIn('id',$imageIn);

            if($imageNotIn)
                $this->whereNotIn('id',$imageNotIn);
        }
        return $this;
    }
}
