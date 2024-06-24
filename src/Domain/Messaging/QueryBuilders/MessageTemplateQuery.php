<?php

namespace Domain\Messaging\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MessageTemplateQuery extends Builder
{

    public function basicKeywordSearch(string $keyword)
    {
        return $this->like(['id', 'name', 'subject', 'alt_body'], $keyword);
    }
    public function search(Request $request): static
    {
        $request
            ->whenFilled(
                'keyword',
                fn () => $this->basicKeywordSearch($request->keyword) && false
            );
        if ($request->filled('category_id')) {
            $this->where('category_id', $request->category_id);
        }
        return $this;
    }
}
