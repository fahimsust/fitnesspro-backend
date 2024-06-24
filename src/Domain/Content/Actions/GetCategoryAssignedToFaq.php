<?php

namespace Domain\Content\Actions;

use Domain\Content\Models\Faqs\Faq;
use Domain\Content\Models\Faqs\FaqsCategories;
use Lorisleiva\Actions\Concerns\AsObject;

class GetCategoryAssignedToFaq
{
    use AsObject;

    public function handle(
        Faq $faq,
        int $category_id,
    ): ?FaqsCategories {
        return $faq->faq_categories()->whereCategoriesId($category_id)->first();
    }
}
