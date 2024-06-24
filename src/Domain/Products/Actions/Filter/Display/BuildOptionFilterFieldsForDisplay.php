<?php

namespace Domain\Products\Actions\Filter\Display;

use Domain\Products\Contracts\BuildFilterFieldForDisplayAction;
use Domain\Products\Models\Filters\Filter;
use Domain\Products\Models\Filters\FilterProductOption;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\ValueObjects\FilterField;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;

class BuildOptionFilterFieldsForDisplay
    extends AbstractAction
    implements BuildFilterFieldForDisplayAction
{
    public array $fields = [];

    public function __construct(
        public Filter     $filter,
        public Request    $request,
        public Collection $optionValues,
    )
    {
    }

    public function execute(): array
    {
        $this->filter
            ->productOptions()
            ->where('status', true)
            ->orderBy('rank', 'asc')
            ->get()
            ->each(
                fn(FilterProductOption $option) => $this->fields[] = FilterField::fromFilterProductOptionModel(
                    $this->filter,
                    $option,
                    $this->optionValues[$option->option_name],
                    $this->request->input(
                        'option_filter.' . $this->filter->id
                    )
                )
            );

        return $this->fields;
    }
}
