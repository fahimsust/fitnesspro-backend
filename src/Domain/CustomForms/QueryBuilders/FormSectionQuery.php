<?php

namespace Domain\CustomForms\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class FormSectionQuery extends Builder
{
    public function basicKeywordSearch(?string $keyword)
    {
        return $this->like(['id','title'], $keyword);
    }
}
