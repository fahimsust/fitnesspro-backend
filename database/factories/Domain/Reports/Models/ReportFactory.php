<?php

namespace Database\Factories\Domain\Reports\Models;

use Carbon\Carbon;
use Domain\Reports\Enums\ReportReady;
use Domain\Reports\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $start_date = new Carbon('1 year ago');
        $end_date = Carbon::tomorrow();
        return [
            'name' => $this->faker->title,
            'created' => Carbon::now(),
            'type_id' => 13,
            'ready' => ReportReady::COMPLETED->value,
            'from_date' => $start_date->toDateTimeString(),
            'to_date' => $end_date->toDateTimeString(),
            'breakdown' => 0,
            'restart' => 0,
            'criteria' => '{}',
            'variables' => '{}',
        ];
    }
}
