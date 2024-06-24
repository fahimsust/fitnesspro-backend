<?php

namespace App\Api\Admin\Accounts\Requests;

use Domain\Accounts\Models\AccountStatus;
use Domain\Accounts\Models\AccountType;
use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class AccountSearchRequest extends FormRequest
{
    use HasFactory;

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
            'first_name' => ['string', 'nullable'],
            'last_name' => ['string', 'nullable'],
            'city' => ['string', 'nullable'],
            'status_id' => ['numeric', 'exists:' . AccountStatus::Table() . ',id', 'nullable'],
            'type_id' => ['numeric', 'exists:' . AccountType::Table() . ',id', 'nullable'],
            'country_id' => ['numeric', 'exists:' . Country::Table() . ',id', 'nullable'],
            'state_id' => ['numeric', 'exists:' . StateProvince::Table() . ',id', 'nullable'],
        ];
    }
}
