<?php

namespace Tests\RequestFactories\App\Api\Admin\Discounts\Requests;

use Carbon\Carbon;
use Worksome\RequestFactories\RequestFactory;

class DiscountRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        $startDate = Carbon::createFromTimestamp($this->faker->dateTimeBetween('-1 years', '+1 years')->getTimestamp());
        $startDateFormatted = $startDate->format('Y-m-d H:i:s');
        $endDate = clone $startDate;
        $endDate->addDays(rand(1, 5));
        $endDateFormatted = $endDate->format('Y-m-d H:i:s');

        return [
            'display' => $this->faker->name,
            'name' => $this->faker->name,
            'start_date' => $startDateFormatted,
            'end_date' => $endDateFormatted,
            'limit_uses'=>$this->faker->randomDigit,
            'limit_per_order'=>$this->faker->randomDigit,
            'limit_per_customer'=>$this->faker->randomDigit,
        ];
    }
}
