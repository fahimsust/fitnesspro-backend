<?php

namespace App\Api\Admin\Reports\Requests;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountType;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Accounts\Models\Specialty;
use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Domain\Orders\Models\Order\Shipments\ShipmentStatus;
use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Attribute\AttributeSet;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Product\ProductType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Worksome\RequestFactories\Concerns\HasFactory;

class SalesReportRequest extends FormRequest
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
        if (isset($this->salesReport->id)) {
            $validation[] = 'unique:reports,name,'.$this->salesReport->id;
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
            'account_id' => [
                'int',
                'exists:' . Account::Table() . ',id',
                'nullable',
            ],
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
            'format' => ['int', 'nullable',Rule::in([0,1,2,3])],
            'order_statuses' => [
                'array',
                'nullable',
            ],
            'order_statuses.*' => [
                'int',
                Rule::exists(ShipmentStatus::Table(), 'id'),
            ],
            'brand_id' => [
                'int',
                'exists:' . Brand::Table() . ',id',
                'nullable',
            ],
            'product_type_id' => [
                'int',
                'exists:' . ProductType::Table() . ',id',
                'nullable',
            ],
            'product_keyword' => ['string', 'nullable'],
            'attribute_set_id' => [
                'int',
                'exists:' . AttributeSet::Table() . ',id',
                'nullable',
            ],
            'attribute_id' => [
                'int',
                'exists:' . Attribute::Table() . ',id',
                'nullable',
            ],
            'attribute_option_id' => [
                'int',
                'exists:' . AttributeOption::Table() . ',id',
                'nullable',
            ],
        ];
    }
}
