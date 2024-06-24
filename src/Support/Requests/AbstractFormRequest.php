<?php

namespace Support\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractFormRequest extends FormRequest
{
    protected $rules = [];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            '*.numeric' => __(':Attribute must be a number'),
        ];
    }

    protected function paginateRules()
    {
        $this->rules += [
            'page' => ['nullable', 'numeric', 'min:1'],
            'limit' => ['nullable', 'numeric', 'min:1', 'max:25'], //defaults to 25
        ];

        return $this;
    }

    /**
     * @return array
     */
    protected function startOfDateRange($fieldName): array
    {
        return [
            'nullable',
            'date_format:"Y-m-d H:i:s"',
            function ($attribute, $value, $fail) use ($fieldName) {
                $endOfRange = request($fieldName)['end'] ?? null;
                if ($endOfRange !== null && $value > $endOfRange) {
                    $fail(__('Start of date range cannot be greater than end of date range'));
                }
            },
        ];
    }

    /**
     * @return array
     */
    protected function endOfDateRange($fieldName): array
    {
        return [
            'nullable',
            'date_format:"Y-m-d H:i:s"',
            function ($attribute, $value, $fail) use ($fieldName) {
                $startOfRange = request($fieldName)['start'] ?? null;
                if ($startOfRange !== null && $value < $startOfRange) {
                    $fail(__('End of date range cannot be less than start of date range'));
                }
            },
        ];
    }
}
