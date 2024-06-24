<?php
namespace Domain\Products\QueryBuilders;

use App\Api\Admin\AccessoryField\Requests\AccessoryFieldSearchRequest;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Builder;

class AccessoryFieldQuery extends Builder
{
    public function basicKeywordSearch(string $keyword)
    {
        return $this->like(['id', 'name'], $keyword);
    }
    public function search(AccessoryFieldSearchRequest $request): static
    {
        $request
            ->whenFilled(
                'keyword',
                fn () => $this->basicKeywordSearch($request->keyword) && false
            );
        if ($request->filled('product_id')) {
            $accessories_fields_id = Product::find($request->product_id)->productAccessoryFields->pluck('accessories_fields_id')->toArray();
            if($accessories_fields_id)
                $this->whereNotIn('id',$accessories_fields_id);
        }
        return $this;

    }
}
