<?php

namespace Domain\Products\Actions\ProductOptions;

use App\Api\Admin\ProductOptions\Requests\CreateDateOptionValuesRequest;
use Carbon\Carbon;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateDateOptionValues
{
    use AsObject;

    public function handle(
        CreateDateOptionValuesRequest $request,
        ProductOption $productOption,

    ) {
        $start_date = new Carbon($request->start_date);
        $end_date = new Carbon($request->end_date);
        $duration = $request->days_duration;
        $days_skip_between = $request->days_skip_between;

        $name = "{START_DATE}-{END_DATE}";
        $display = "{START_DATE} thru {END_DATE}";

        $total_created = 0;

        while ($start_date < $end_date && $start_date->diffInDays($end_date) >= $duration) {
            $start_date_string = $start_date->toDateString();
            $stop = $start_date->addDays($duration);

            $productOption->optionValues()->create([
                'name' => $name,
                'display' => $display,
                'start_date' => $start_date_string,
                'end_date' => $stop->toDateString()
            ]);

            $start_date = $stop->addDays($days_skip_between);
            $total_created++;
        }
        return $productOption->optionValues;
    }
}
