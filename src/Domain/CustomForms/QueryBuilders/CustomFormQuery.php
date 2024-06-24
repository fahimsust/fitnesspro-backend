<?php

namespace Domain\CustomForms\QueryBuilders;

use Domain\CustomForms\Models\ProductForm;
use Illuminate\Database\Eloquent\Builder;

class CustomFormQuery extends Builder
{
    public function basicKeywordSearch(?string $keyword)
    {
        return $this->like(['id','name'], $keyword);
    }
    public function availableToAssignToProduct(int $product_id, ?string $keyword)
    {
        return $this->basicKeywordSearch($keyword)
            ->whereNotIn(
                'id',
                ProductForm::whereProductId($product_id)
                    ->select('form_id')
                    ->pluck('form_id')
            );
    }
}
