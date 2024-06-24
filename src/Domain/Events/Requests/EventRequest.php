<?php

namespace Domain\Events\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'title' => ['string', 'required'],
            'description' => ['string', 'required'],
            'sdate' => ['date', 'required'],
            'edate' => ['date', 'required'],
            'timezone' => ['date', 'required'],
            'created' => ['date', 'required'],
            'createdby' => ['numeric', 'required'],
            'photo' => ['numeric', 'required'],
            'type' => ['required'],
            'type_id' => ['required'],
            'city' => ['string', 'required'],
            'state' => ['required'],
            'country' => ['required'],
            'email' => ['email', 'required'],
            'phone' => ['numeric', 'required'],
            'webaddress' => ['string', 'required'],
            'views' => ['numeric', 'required'],
        ];
    }
}
