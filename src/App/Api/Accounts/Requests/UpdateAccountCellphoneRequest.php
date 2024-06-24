<?php

namespace App\Api\Accounts\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountCellphoneRequest extends FormRequest
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
            'new_cellphone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:14',
        ];
    }
}
