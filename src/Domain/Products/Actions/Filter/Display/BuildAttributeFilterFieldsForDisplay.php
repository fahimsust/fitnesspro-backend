<?php

namespace Domain\Products\Actions\Filter\Display;

use Domain\Products\Contracts\BuildFilterFieldForDisplayAction;
use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Filters\Filter;
use Domain\Products\Models\Filters\FilterAttribute;
use Domain\Products\ValueObjects\FilterField;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;

class BuildAttributeFilterFieldsForDisplay
    extends AbstractAction
    implements BuildFilterFieldForDisplayAction
{
    public array $fields = [];

    public function __construct(
        public Filter     $filter,
        public Request    $request,
        public Collection $attributeValues,
    )
    {
    }

    public function execute(): array
    {
        $this->filter
            ->filterAttributes()
            ->where(FilterAttribute::Table().'.status', 1)
            ->orderBy(FilterAttribute::Table().'.rank', 'asc')
            ->get()
            ->each(
                fn(FilterAttribute $attribute) => $this->fields[] = FilterField::fromFilterAttributeModel(
                    $attribute,
                    $this->attributeValues[$attribute->attribute_id],
                    $this->request->input(
                        'att_filter.' . $attribute->attribute_id
                    )
                )
            );

        return $this->fields;
    }
}
