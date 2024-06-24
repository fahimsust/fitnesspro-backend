<?php

namespace App\Api\Admin\Sites\Requests;

use Domain\Accounts\Models\AccountType;
use Domain\Sites\Enums\RequireLogin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DefaultAccountTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'account_type_id' => ['numeric', 'exists:' . AccountType::Table() . ',id', 'required'],
            'required_account_types' => ['array','nullable'],
            'requireLogin' => ['string',Rule::in(array_column(RequireLogin::cases(),'value')),'required'],
        ];
    }
}
