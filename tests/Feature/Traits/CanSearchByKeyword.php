<?php

namespace Tests\Feature\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CanSearchByKeyword
{
    public function like(string|array $columns, ?string $keyword = null): static
    {
        if(!$keyword)
            return $this;

        return $this->where(
            function ($query) use ($columns, $keyword) {
                foreach ($columns as $column)
                    $query->orWhere($column, 'LIKE', "%{$keyword}%");
            }
        );
    }
}
