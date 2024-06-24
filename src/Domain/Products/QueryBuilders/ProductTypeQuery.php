<?php

namespace Domain\Products\QueryBuilders;

use Domain\Discounts\Models\Advantage\AdvantageProductType;
use Domain\Discounts\Models\Rule\Condition\ConditionProductType;
use Domain\Products\Models\Attribute\AttributeSet;
use Domain\Products\Models\Category\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductTypeQuery extends Builder
{
    public function basicKeywordSearch(?string $keyword = null)
    {
        return $this->like(['id', 'name'], $keyword);
    }
    public function search(Request $request): static
    {
        $request
            ->whenFilled(
                'keyword',
                fn () => $this->basicKeywordSearch($request->keyword) && false
            );
        if ($request->filled('category_id')) {
            $type_ids = Category::find($request->category_id)->categoryProductTypes->pluck('type_id')->toArray();
            if($type_ids)
                $this->whereNotIn('id',$type_ids);
        }
        if ($request->filled('attribute_set_id')) {
            $type_ids = AttributeSet::find($request->attribute_set_id)->productTypes->pluck('id')->toArray();
            if($type_ids)
                $this->whereIn('id',$type_ids);
        }
        if ($request->filled('advantage_id')) {
            $type_ids = AdvantageProductType::whereAdvantageId($request->advantage_id)->get()->pluck('producttype_id')->toArray();
            if($type_ids)
                $this->whereNotIn('id',$type_ids);
        }
        if ($request->filled('condition_id')) {
            $type_ids = ConditionProductType::whereConditionId($request->condition_id)->get()->pluck('producttype_id')->toArray();
            if($type_ids)
                $this->whereNotIn('id',$type_ids);
        }

        return $this;

    }
}
