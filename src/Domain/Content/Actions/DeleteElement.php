<?php

namespace Domain\Content\Actions;

use Domain\Content\Models\Element;
use Lorisleiva\Actions\Concerns\AsObject;

class DeleteElement
{
    use AsObject;

    public function handle(
        Element $element
    ): bool {
        if ($element->searchFormFields()->exists()) {
            throw new \Exception(__(
                "Can't delete: there are search fields using this element.  Update these fields before deleting :fields",
                [
                    'form' => $element->searchFormFields()
                        ->pluck('display')
                        ->implode(', '),
                ]
            ));
        }

        if ($element->sitePackingSlips()->exists()) {
            throw new \Exception(__(
                "Can't delete: there are packing slips using this element.  Update them before deleting this element."
            ));
        }

        $element->delete();

        return true;
    }
}
