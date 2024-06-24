<?php

namespace Domain\Products\Actions\Filter\Display;

use Domain\Products\Contracts\BuildFilterFieldForDisplayAction;
use Domain\Products\Models\Filters\Filter;
use Domain\Products\ValueObjects\FilterField;
use Illuminate\Http\Request;
use Support\Contracts\AbstractAction;

class BuildAvailabilityFilterFieldForDisplay
    extends AbstractAction
    implements BuildFilterFieldForDisplayAction
{
    public array $fields = [];

    public function __construct(
        public Filter  $filter,
        public Request $request,
    )
    {
    }

    public function execute(): array
    {
        $this->fields[] = FilterField::fromFilterModel(
                $this->filter,
                "avail_filter",
                $this->filter
                    ->filterAvailabilities()
                    ->addSelect(
                        \DB::raw('id as value'),
                        \DB::raw('label as display')
                    )
                    ->where('status', 1)
                    ->orderBy('rank', 'asc')
                    ->get(),
                $this->request->input(
                    'avail_filter'//.' . $this->filter->id
                )
            );

        return $this->fields;
    }
}
