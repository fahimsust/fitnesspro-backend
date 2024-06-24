<?php

namespace Domain\Modules\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ModuleTemplateQuery extends Builder
{

    public function basicKeywordSearch(string $keyword)
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
        if ($request->filled('parent_template_id')) {
            $this->where('parent_template_id', $request->parent_template_id);
        }
        return $this;
    }
}
