<?php

namespace Domain\Events\Requests;

use Domain\Accounts\Models\Account;
use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Support\Requests\AbstractFormRequest;

class SearchEventsRequest extends AbstractFormRequest
{
    public function attributes()
    {
        return [
            'event_dates.start' => __("Event's start date - starting date"),
            'event_dates.end' => __("Event's start date - ending date"),
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
            'title' => ['nullable', 'string'],
            'created_by' => ['nullable', 'exists:'.Account::table().',id'],
            'city' => ['nullable', 'string'],
            'state_alpha2' => ['nullable', 'exists:'.StateProvince::table().',abbreviation'],
            'country_alpha2' => ['nullable', 'exists:'.Country::table().',abbreviation'],
            'type_id' => ['nullable', 'in:'],
            'event_starts.start' => $this->startOfDateRange('event_starts'),
            'event_starts.end' => $this->endOfDateRange('event_starts'),
            'event_ends.start' => $this->startOfDateRange('event_ends'),
            'event_ends.end' => $this->endOfDateRange('event_ends'),
        ];

        $this->paginateRules();

        return $this->rules;
    }
}
