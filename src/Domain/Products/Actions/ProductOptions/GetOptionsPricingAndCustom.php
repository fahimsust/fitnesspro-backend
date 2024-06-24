<?php

namespace Domain\Products\Actions\ProductOptions;

use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Products\Models\Product\Option\ProductOption;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsObject;
use const Domain\Products\Actions\POPTVAL_DATEFORMAT;

class GetOptionsPricingAndCustom
{
    use AsObject;

    public array $optionDetails;
    public array $optionIds;
    public int $optionPrice;

    public function handle(
        array $options,
        ?OrderItem $orderItem = null
    ): static {
        if (! count($options)) {
            return $this;
        }

        $productOptions = ProductOption::select(
            'o.id',
            'o.name',
            'o.display',
            'o.rank',
            'o.type_id',
            DB::raw('v.id as vid'),
            DB::raw('v.display as vdisplay'),
            DB::raw("IF(v.start_date IS NOT NULL, REPLACE(REPLACE(v.display, '{END_DATE}', DATE_FORMAT(v.end_date, '" . POPTVAL_DATEFORMAT . "')), '{START_DATE}', DATE_FORMAT(v.start_date, '" . POPTVAL_DATEFORMAT . "')), v.display) as vreal_display"),
            DB::raw('v.price as vprice'),
            DB::raw('c.custom_type as vcustom_type')
        )
            ->joinRelationship(
                'optionValues',
                fn ($join) => $join->as('optionValues')
            )
            ->leftJoinRelationship(
                'optionValues.custom',
                fn ($join) => $join->as('custom')
            )
            ->when(
                ! is_null($orderItem),
                fn (Builder $query) => $query->addSelect(
                    DB::raw('orderItemOption.custom_value as vcustom_value'),
                    'orderItemOption.price as vprice'
                )
                    ->leftJoinRelationship(
                        'optionValues.orderItemOption',
                        fn ($join) => $join->as('orderItemOption')
                    )
            )
            ->when(
                is_null($orderItem),
                fn (Builder $query) => $query->addSelect(DB::raw('optionValues.price as vprice'))
            )
            ->whereIn('optionValues.id', collect($options)->flatten())
            ->orderBy('optionValues.id')
            ->get()
            ->each(
                function (ProductOption $productOption) {
                    $details = [
                        'id' => $productOption->id,
                        'name' => $productOption->name,
                        'display' => $productOption->display,
                        'type' => $productOption->type_id,
                        'value_id' => [$productOption->vid],
                        'value_price' => [$productOption->vprice],
                        'value_display' => [$productOption->vreal_display],
                    ];

                    if ($productOption->vcustom_value !== '') {
                        $details['value_custom_type'][] = $productOption->vcustom_type;
                        $details['value_custom_value'][] = $productOption->vcustom_value;
                    } elseif (isset($options['custom_values'][$productOption->vid])) {//has custom value
                        if (empty($options['custom_values'][$productOption->vid])) {
                            throw new \Exception(
                                __("You selected :display1 for :display2, but didn't provide any value.  Please fill a value for :display3", [
                                    'display1' => $productOption->vreal_display,
                                    'display2' => $productOption->display,
                                    'display3' => $productOption->vdisplay,
                                ])
                            );
                        }

                        $details['value_custom_type'][] = $productOption->vcustom_type;
                        $details['value_custom_value'][] = $options['custom_values'][$productOption->vid];
                    } else {
                        $details[$productOption->id]['value_custom_type'][] = -1;
                    }

                    $this->optionDetails[$productOption->id] = $details;
                }
            );

        $this->optionIds = $productOptions->map(
            fn (ProductOption $option) => $option->vid
        )->toArray();

        $this->optionPrice = $productOptions->sum('vprice');

        return $this;
    }
}
