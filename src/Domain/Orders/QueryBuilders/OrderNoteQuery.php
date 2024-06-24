<?php

namespace Domain\Orders\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class OrderNoteQuery extends Builder
{

    public function basicKeywordSearch(?string $keyword = null)
    {
        return $this->like(['id', 'note'], $keyword);
    }
}
