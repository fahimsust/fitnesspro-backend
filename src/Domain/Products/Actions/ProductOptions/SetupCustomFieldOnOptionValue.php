<?php

namespace Domain\Products\Actions\ProductOptions;

use App\Api\Admin\ProductOptions\Requests\CustomFieldOptionValueRequest;
use Domain\Products\Models\Product\Option\ProductOptionCustom;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class SetupCustomFieldOnOptionValue
{
    use AsObject;

    public function handle(
        ProductOptionValue     $productOptionValue,
        CustomFieldOptionValueRequest $request
    ): ProductOptionCustom {

        $updateArray = [
            'custom_type' => $request->custom_type,
            'custom_charlimit' => $request->custom_charlimit,
            'custom_label' => $request->custom_label,
            'custom_instruction' => $request->custom_instruction,
        ];
        if ($productOptionValue->custom()->exists())
        {
            $productOptionValue->custom()->update($updateArray);
        }
        else
        {
            $productOptionValue->custom()->create($updateArray);
        }



        $productOptionValue->update(['is_custom' => true]);

        return $productOptionValue->custom;
    }
}
