<?php

namespace App\Api\Admin\Reports\Requests;

use Domain\Accounts\Models\AccountType;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Accounts\Models\Specialty;
use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Worksome\RequestFactories\Concerns\HasFactory;

class CustomerReportRequest extends FormRequest
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
    public function nameRule()
    {
        $validation = ['string', 'max:155', 'required'];
        if (isset($this->customerReport->id)) {
            $validation[] = 'unique:reports,name,'.$this->customerReport->id;
        } else {
            $validation[] = 'unique:reports';
        }
        return $validation;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => $this->nameRule(),
            'start_date' => ['date', 'nullable'],
            'end_date' => ['date', 'after:start_date', 'nullable'],
            'account_status' => ['int', 'nullable',Rule::in([0,1,2,3,4,5])],
            'account_type_id' => [
                'array',
                'nullable',
            ],
            'account_type_id.*' => [
                'int',
                Rule::exists(AccountType::Table(), 'id'),
            ],
            'ship_to_country' => ['numeric', 'exists:' . Country::Table() . ',id', 'nullable'],
            'ship_to_city' => ['string','max:255', 'nullable'],
            'has_ordered' => ['int', 'nullable',Rule::in([0,1,2])],
            'ship_to_state' => [
                'array',
                'nullable',
            ],
            'ship_to_state.*' => [
                'int',
                Rule::exists(StateProvince::Table(), 'id'),
            ],
            'specialties' => [
                'array',
                'nullable',
            ],
            'specialties.*' => [
                'int',
                Rule::exists(Specialty::Table(), 'id'),
            ],
            'specialty_allany' => ['int', 'nullable',Rule::in([0,1])],
            'membership_level' => ['numeric', 'exists:' . MembershipLevel::Table() . ',id', 'nullable'],
        ];
    }
}
