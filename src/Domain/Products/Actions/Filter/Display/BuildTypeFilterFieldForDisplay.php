<?php

namespace Domain\Products\Actions\Filter\Display;

use Domain\Products\Contracts\BuildFilterFieldForDisplayAction;
use Domain\Products\Models\Filters\Filter;
use Domain\Products\ValueObjects\FilterField;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;

class BuildTypeFilterFieldForDisplay
    extends AbstractAction
    implements BuildFilterFieldForDisplayAction
{
    public array $fields = [];

    public function __construct(
        public Filter     $filter,
        public Request    $request,
        public Collection $types,
    )
    {
    }

    public function execute(): array
    {
        $this->fields[] = FilterField::fromFilterModel(
            $this->filter,
            "type_filter",
            $this->types,
            $this->request->input(
                'type_filter',//.' . $this->filter->id
            )
        );

        return $this->fields;
    }
}
