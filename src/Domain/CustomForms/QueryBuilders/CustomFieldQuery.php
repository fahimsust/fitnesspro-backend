<?php

namespace Domain\CustomForms\QueryBuilders;
use Illuminate\Database\Eloquent\Builder;

class CustomFieldQuery extends Builder
{
    public function basicKeywordSearch(?string $keyword)
    {
        return $this->like(['id','name','display'], $keyword);
    }
}
