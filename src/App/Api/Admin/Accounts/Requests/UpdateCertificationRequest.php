<?php

namespace App\Api\Admin\Accounts\Requests;


class UpdateCertificationRequest extends AccountCertificationRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = parent::rules();

        // Remove 'account_id' validation as it's not needed for update.
        unset($rules['account_id']);

        // Make 'file_name' not required for the update.
        $rules['file_name'] = ['file', 'mimes:pdf,jpg,png', 'max:2048', 'nullable'];

        return $rules;
    }
}
