<?php

namespace App\Api\Admin\Discounts\Requests;

use Domain\Addresses\Models\Address;
use Domain\Discounts\Enums\DiscountAdvantageTypes;
use Domain\Discounts\Models\Discount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;
use Illuminate\Validation\Rules\Enum;

class DiscountAdvantageRequest extends FormRequest
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
            'discount_id' => [
                'int',
                'exists:' . Discount::Table() . ',id',
                'required'
            ],
            'advantage_type_id' => ['int',new Enum(DiscountAdvantageTypes::class),'required'],
            'amount' => ['numeric','nullable'],
            'apply_shipping_id' => [
                'int',
                'exists:' . Address::Table() . ',id',
                'nullable'
            ],
            'apply_shipping_country' => ['numeric','nullable'],
            'apply_shipping_distributor' => ['numeric','nullable'],
            'applyto_qty_type' => ['boolean','nullable'],
            'applyto_qty_combined' => ['numeric','nullable'],
        ];
    }
}
