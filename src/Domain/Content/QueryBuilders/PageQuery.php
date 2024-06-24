<?php

namespace Domain\Content\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Tests\Feature\Traits\CanSearchByKeyword;

class PageQuery extends Builder
{
    use CanSearchByKeyword;

    public function basicKeywordSearch(string $keyword)
    {
        return $this->like(['title', 'url_name'], $keyword);
    }
}
