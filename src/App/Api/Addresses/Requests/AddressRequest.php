<?php

namespace App\Api\Addresses\Requests;

use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\WithData;
use Support\Dtos\AddressDto;
use Worksome\RequestFactories\Concerns\HasFactory;

class AddressRequest extends FormRequest
{
    use WithData,
        HasFactory;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'label' => ['string', 'max:55', 'required'],
            'company' => ['string', 'max:85', 'nullable'],
            'first_name' => ['string', 'max:55', 'required'],
            'last_name' => ['string', 'max:55', 'required'],
            'address_1' => ['string', 'max:100', 'required'],
            'address_2' => ['string', 'max:100', 'nullable'],
            'city' => ['string', 'max:35', 'required'],
            'state_id' => [
                Rule::requiredIf(function () {
                    $requiredCountryIds = config('account_fields.required_state_country_id');
                    return in_array($this->input('country_id'), $requiredCountryIds);
                }),
                'numeric',
                'nullable',
                'exists:' . StateProvince::Table() . ',id'
            ],
            'country_id' => ['numeric', 'nullable', 'exists:' . Country::Table() . ',id'],
            'postal_code' => ['string', 'max:15', 'required'],
            'email' => ['string', 'email', 'max:85', 'nullable'],
            'phone' => ['string', 'max:35', 'nullable'],
            'is_residential' => ['min:0', 'max:1', 'nullable'],
        ];
    }

    public function messages()
    {
        return [
            'state_id.required' => 'State is required',
        ];
    }

    protected function dataClass(): string
    {
        return AddressDto::class;
    }
}
