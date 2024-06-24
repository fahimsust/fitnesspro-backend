<?php

namespace App\Api\Admin\Discounts\Requests;

use Domain\Distributors\Models\Distributor;
use Domain\Locales\Models\Country;
use Domain\Orders\Models\Shipping\ShippingMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class DiscountAdvantageUpdateRequest extends FormRequest
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
            'amount' => ['numeric','nullable'],
            'apply_shipping_id' => [
                'int',
                'exists:' . ShippingMethod::Table() . ',id',
                'nullable'
            ],
            'apply_shipping_country' => [
                'int',
                'exists:' . Country::Table() . ',id',
                'nullable'
            ],
            'apply_shipping_distributor' => [
                'int',
                'exists:' . Distributor::Table() . ',id',
                'nullable'
            ],
            'applyto_qty_type' => ['boolean','nullable'],
            'applyto_qty_combined' => ['numeric','nullable'],
        ];
    }
}
