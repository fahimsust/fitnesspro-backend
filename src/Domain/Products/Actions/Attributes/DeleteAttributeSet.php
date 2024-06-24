<?php

namespace Domain\Products\Actions\Attributes;

use Domain\Products\Models\Attribute\AttributeSet;
use Lorisleiva\Actions\Concerns\AsObject;

class DeleteAttributeSet
{
    use AsObject;

    public function handle(
        AttributeSet $attributeSet,
    )
    {
        if ($this->isUsedByProducts($attributeSet->id)) {
            throw new \Exception(
                __(
                    "Can't delete: there are products using this attribute set.  Update these products before deleting: :products",
                    [
                        'products' => $attributeSet->products()->select('title')
                        ->limit(5)->pluck('title')->implode(', ')
                    ]
                )
            );
        }

        $attributeSet->attributesSetAttribute()->delete();
        $attributeSet->attributesSetProductType()->delete();
        $attributeSet->delete();
    }

    /**
     * @param AttributeSet $attributeSet
     * @return bool
     */
    protected function isUsedByProducts(int $attributeSetId): bool
    {
        return AttributeSet::whereId($attributeSetId)->whereHas('products')->exists();
    }
}
