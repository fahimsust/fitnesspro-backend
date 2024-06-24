<?php

namespace Domain\Products\Actions\Filter\Display;

use Domain\Products\Contracts\BuildFilterFieldForDisplayAction;
use Domain\Products\Models\Filters\Filter;
use Domain\Products\ValueObjects\FilterField;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;

class BuildBrandFilterFieldForDisplay
    extends AbstractAction
    implements BuildFilterFieldForDisplayAction
{
    public array $fields = [];

    public function __construct(
        public Filter     $filter,
        public Request    $request,
        public Collection $brands,
    )
    {
    }

    public function execute(): array
    {
        $this->fields[] = FilterField::fromFilterModel(
            $this->filter,
            "brand_filter",
            $this->brands,
            $this->request->input(
                'brand_filter'//.' . $this->filter->id
            )
        );

        return $this->fields;
    }
}
