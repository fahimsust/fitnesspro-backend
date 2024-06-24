<?php

namespace Domain\Products\Actions\Types;

use App\Api\Admin\Products\Types\Requests\ProductTypeTaxRuleRequest;
use Domain\Products\Models\Product\ProductType;
use Domain\Tax\Models\TaxRuleProductType;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsObject;

class AssignTaxRuleToProductType
{
    use AsObject;

    private ProductTypeTaxRuleRequest $request;
    private ProductType $productType;

    private array $allTaxRule;

    public function handle(
        ProductType $productType,
        ProductTypeTaxRuleRequest $request
    ): void
    {
        $this->request = $request;
        $this->productType = $productType;

        $this->unassignUnselectedTaxRule($productType);
        $this->assignSelectedTaxRule();
    }

    protected function assignSelectedTaxRule()
    {
        if (!count($this->request->rule_ids)) {
            return;
        }

        DB::table(TaxRuleProductType::Table())->insertOrIgnore(
            array_map(
                fn(int|string $taxRuleId) => [
                    'type_id' => $this->productType->id,
                    'tax_rule_id' => $taxRuleId,
                ],
                $this->request->rule_ids
            )
        );
    }

    protected function unassignUnselectedTaxRule(): void
    {
        $missingRuleId = array_diff($this->allTaxRuleOfType(), $this->request->rule_ids);

        if (!count($missingRuleId)) {
            return;
        }

        TaxRuleProductType::whereIn('tax_rule_id', $missingRuleId)
            ->where('type_id', $this->productType->id)
            ->delete();
    }

    private function allTaxRuleOfType(): array
    {
        return $this->allTaxRule ??=  $this->productType->taxRules
            ->pluck('id')
            ->toArray();
    }
}
