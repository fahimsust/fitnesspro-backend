<?php

namespace Domain\Content\QueryBuilders;

use Domain\Content\Models\Faqs\Faq;
use Domain\Content\Models\Faqs\FaqsCategories;
use Illuminate\Database\Eloquent\Builder;
use Tests\Feature\Traits\CanSearchByKeyword;
use Illuminate\Http\Request;

class FaqCategoryQuery extends Builder
{
    use CanSearchByKeyword;

    public function basicKeywordSearch(string $keyword)
    {
        return $this->like(['title', 'id'], $keyword);
    }
    public function search(Request $request): static
    {
        $request
            ->whenFilled(
                'keyword',
                fn () => $this->basicKeywordSearch($request->keyword) && false
            );
        if ($request->filled('faq_id')) {
            $this->where('status',true);
            $categories_ids = Faq::find($request->faq_id)->faq_categories()->pluck('categories_id')->toArray();
            if($categories_ids)
                $this->whereNotIn('id',$categories_ids);
        }

        return $this;

    }
}
