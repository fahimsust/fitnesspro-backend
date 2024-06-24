<?php

namespace Domain\Products\ValueObjects;

use Domain\Products\Models\Filters\Filter;
use Domain\Products\Models\Filters\FilterAttribute;
use Domain\Products\Models\Filters\FilterProductOption;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class FilterField extends Data
{
    public ?int $attribute_id = null;

    public ?string $option_name = null;


    public string $name;
    public string $label;
    public Collection $options;
    public mixed $compare;

    public static function fromFilterAttributeModel(
        FilterAttribute $attribute,
        Collection      $attribute_values,
        mixed           $compare
    )
    {
        return static::from([
            'attribute_id' => $attribute->id,
            'name' => "att_filter[{$attribute->id}]",
            'label' => $attribute->label,
            'options' => $attribute_values,
            'compare' => $compare
        ]);
    }

    public static function fromFilterProductOptionModel(
        Filter              $filter,
        FilterProductOption $option,
        Collection          $option_values,
        mixed               $compare
    ): self
    {
        return static::from([
            'option_name' => $option->option_name,
            'name' => "option_filter[{$filter->id}]",
            'label' => $filter->label,
            'options' => $option_values,
            'compare' => $compare
        ]);
    }

    public static function fromFilterModel(
        Filter     $filter,
        string     $name,
        Collection $options,
        mixed      $compare
    )
    {
        return static::from([
            'name' => "{$name}[{$filter->id}]",
            'label' => $filter->label,
            'options' => $options,
            'compare' => $compare
        ]);
    }
}
