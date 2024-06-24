<?php

namespace Domain\Products\Actions\Types;

use App\Api\Admin\Products\Types\Requests\ProductTypeAttributeSetRequest;
use Domain\Products\Models\Product\ProductType;
use Domain\Products\Models\Product\ProductTypeAttributeSet;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsObject;

class AssignAttributeSetToProductType
{
    use AsObject;

    private ProductTypeAttributeSetRequest $request;
    private ProductType $productType;

    private array $allAttributeSet;

    public function handle(
        ProductType $productType,
        ProductTypeAttributeSetRequest $request
    ): void
    {
        $this->request = $request;
        $this->productType = $productType;

        $this->unassignUnselectedAttributeSet($productType);
        $this->assignSelectedAttributeSet();
    }

    protected function assignSelectedAttributeSet()
    {
        if (!count($this->request->set_ids)) {
            return;
        }

        DB::table(ProductTypeAttributeSet::Table())->insertOrIgnore(
            array_map(
                fn(int|string $setId) => [
                    'type_id' => $this->productType->id,
                    'set_id' => $setId,
                ],
                $this->request->set_ids
            )
        );
    }

    protected function unassignUnselectedAttributeSet(): void
    {
        $missingSetsId = array_diff(array_unique($this->allAttributeSetOfType()), array_unique($this->request->set_ids));

        if (!count($missingSetsId)) {
            return;
        }
        ProductTypeAttributeSet::whereIn('set_id', $missingSetsId)
            ->where('type_id', $this->productType->id)
            ->delete();
    }

    private function allAttributeSetOfType(): array
    {
        return $this->allAttributeSet ??=  $this->productType->attributeSets
            ->pluck('id')
            ->toArray();
    }
}
