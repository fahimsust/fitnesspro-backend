<?php

namespace App\Api\Admin\Products\Requests;

use Domain\Distributors\Models\Distributor;
use Domain\Products\Models\FulfillmentRules\FulfillmentRule;
use Domain\Products\Models\Product\ProductAvailability;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class DefaultInventoryRequest extends FormRequest
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
            'default_outofstockstatus_id' => [
                'int',
                'exists:' . ProductAvailability::Table() . ',id',
                'nullable',
            ],
            'default_distributor_id' => [
                'int',
                'exists:' . Distributor::Table() . ',id',
                'nullable',
            ],
            'fulfillment_rule_id' => [
                'int',
                'exists:' . FulfillmentRule::Table() . ',id',
                'nullable',
            ],
            'default_cost' => ['numeric','nullable'],
            'inventoried' => ['bool','nullable']
        ];
    }
}
