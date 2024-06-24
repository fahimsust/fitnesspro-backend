<?php

namespace App\Api\Accounts\Requests\Registration;

use App\Api\Accounts\Rules\CheckValidLevelMethod;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Accounts\Models\Registration\Registration;
use Illuminate\Foundation\Http\FormRequest;

class SetRegistrationMembershipLevelRequest extends FormRequest
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
            'level_id' => [
                'integer',
                'required',
                'exists:' . MembershipLevel::table() . ',id',
                new CheckValidLevelMethod(),
            ],
        ];
    }
}
