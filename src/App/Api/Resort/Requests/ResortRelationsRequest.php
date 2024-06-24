<?php

namespace App\Api\Resort\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResortRelationsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'relations' => ['nullable', 'array'],
            'relations.*' => [Rule::in($this->relations())],
        ];
    }

    public function relations()
    {
        return [
            'albums',
            'fptManager',
            'airport',
            'country',
            'type',
        ];
    }
}
