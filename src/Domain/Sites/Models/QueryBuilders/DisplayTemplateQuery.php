<?php

namespace Domain\Sites\Models\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DisplayTemplateQuery extends Builder
{
    public function basicKeywordSearch(?string $keyword = null): static
    {
        $this->like(['name'], $keyword);
        return $this;
    }
    public function search(Request $request): static
    {
        $request
            ->whenFilled(
                'keyword',
                fn () => $this->basicKeywordSearch($request->keyword) && false
            );
        if ($request->filled('type_id')) {
            $this->where('type_id', $request->type_id);
        }
        return $this;
    }
}
