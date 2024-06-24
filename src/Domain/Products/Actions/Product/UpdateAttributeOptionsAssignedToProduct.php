<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\Products\Requests\ProductAttributeRequest;
use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Product\ProductAttribute;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateAttributeOptionsAssignedToProduct
{
    use AsObject;

    private ProductAttributeRequest $request;
    private array $allOptionsOfAttribute;
    private array $selectedOptionIds;

    public function handle(
        ProductAttributeRequest $request,
    ): void
    {
        $this->request = $request;

        $this->unassignUnselectedAttributeOptions();
        $this->assignSelectedAttributeOptions();
    }

    protected function assignSelectedAttributeOptions()
    {
        if (!count($this->request->option_ids)) {
            return;
        }
        $this->createNewOption();
        DB::table(ProductAttribute::Table())->insertOrIgnore(
            array_map(
                fn(int|string $optionId) => [
                    'product_id' => $this->request->product_id,
                    'option_id' => $optionId,
                ],
                $this->selectedOptionIds
            )
        );
    }

    private function createNewOption()
    {
        foreach($this->request->option_ids as $value)
        {
            if(AttributeOption::find($value))
            {
                $this->selectedOptionIds[] = $value;
            }
            else if($attributeOption = $this->getAttributeOption($value))
            {
                $this->selectedOptionIds[] = $attributeOption->id;
            }
            else
            {
                $option = AttributeOption::create([
                    'attribute_id'=>$this->request->attribute_id,
                    'rank'=>0,
                    'display'=>$value
                ]);
                $this->selectedOptionIds[] = $option->id;
            }
        }
    }
    private function getAttributeOption($display):?AttributeOption
    {
        return AttributeOption::where('attribute_id',$this->request->attribute_id)->where('display',$display)->first();
    }

    protected function unassignUnselectedAttributeOptions(): void
    {
        $missingOptionIds = array_diff($this->allOptionsOfAttribute(), $this->request->option_ids);

        if (!count($missingOptionIds)) {
            return;
        }

        ProductAttribute::whereIn('option_id', $missingOptionIds)
            ->where('product_id', $this->request->product_id)
            ->delete();
    }

    private function allOptionsOfAttribute(): array
    {
        return $this->allOptionsOfAttribute ??= Attribute::find($this->request->attribute_id)->options
            ->pluck('id')
            ->toArray();
    }
}
