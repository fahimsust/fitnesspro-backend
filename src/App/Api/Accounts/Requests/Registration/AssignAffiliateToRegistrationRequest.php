<?php

namespace App\Api\Accounts\Requests\Registration;

use Domain\Accounts\Models\Registration\Registration;
use Domain\Affiliates\Models\Affiliate;
use Illuminate\Foundation\Http\FormRequest;

class AssignAffiliateToRegistrationRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'affiliate_id' => ['integer', 'required', 'exists:' . Affiliate::table() . ',id'],
        ];
    }
}
