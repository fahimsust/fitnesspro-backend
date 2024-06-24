<?php

namespace Tests\RequestFactories\App\Api\Admin\ProductOptions\Requests;

use Carbon\Carbon;
use Domain\Products\Models\Product\Option\ProductOption;
use Worksome\RequestFactories\RequestFactory;

class CreateDateOptionValuesRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        $start_date = Carbon::now();
        $end_date = Carbon::now()->addDays(28);

        return [
            'start_date' => $start_date->toDateString(),
            'end_date' => $end_date->toDateString(),
            'days_duration' =>6,
            'days_skip_between'=>1,
        ];
    }
}
