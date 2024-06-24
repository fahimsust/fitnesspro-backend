<?php

namespace Domain\Content\Actions;

use App\Api\Admin\Faqs\Requests\FaqCategoresRequest;
use Domain\Content\Models\Faqs\Faq;
use Domain\Content\Models\Faqs\FaqsCategories;
use Lorisleiva\Actions\Concerns\AsObject;

class AssignCategoryToFaq
{
    use AsObject;

    public function handle(
        Faq $faq,
        FaqCategoresRequest $request
    ): FaqsCategories {
        if (GetCategoryAssignedToFaq::run($faq, $request->categories_id)) {
            throw new \Exception(__('Category already assigned to faq'));
        }

        return $faq->faq_categories()->create(
            [
                'categories_id' => $request->categories_id,
            ]
        );
    }
}
