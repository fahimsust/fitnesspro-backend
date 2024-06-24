<?php

namespace Domain\Content\Actions;

use Domain\Content\Models\Faqs\Faq;
use Domain\Content\Models\Faqs\FaqCategory;
use Lorisleiva\Actions\Concerns\AsObject;

class RemoveCategoryFromFaq
{
    use AsObject;

    public function handle(
        Faq $faq,
        int $category_id,
    ): FaqCategory {
        if (! GetCategoryAssignedToFaq::run($faq, $category_id)) {
            throw new \Exception(__('Category not assigned to faq'));
        }

        $faq->faq_categories()->whereCategoriesId($category_id)->delete();

        return FaqCategory::find($category_id, ['title']);
    }
}
