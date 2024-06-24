<?php

namespace App\Api\Accounts\Requests;

use Support\Requests\AbstractFormRequest;

class SearchAccountTripsRequest extends AbstractFormRequest
{
    public function attributes()
    {
        return [
            'trip_starts.start' => __("Trip's departure date - starting date"),
            'trip_starts.end' => __("Trip's departure date - ending date"),
            'trip_ends.start' => __("Trip's return date - start date"),
            'trip_ends.end' => __("Trip's return date - ending date"),
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->rules = [
            'trip_starts.start' => $this->startOfDateRange('trip_starts'),
            'trip_starts.end' => $this->endOfDateRange('trip_starts'),
            'trip_ends.start' => $this->startOfDateRange('trip_ends'),
            'trip_ends.end' => $this->endOfDateRange('trip_ends'),
        ];

        $this->paginateRules();

        return $this->rules;
    }
}
