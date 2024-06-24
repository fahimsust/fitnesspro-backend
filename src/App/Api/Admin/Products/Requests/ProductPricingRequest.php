<?php

namespace App\Api\Admin\Products\Requests;

use Domain\Products\Models\OrderingRules\OrderingRule;
use Domain\Products\Models\Product\Pricing\PricingRule;
use Domain\Sites\Models\Site;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class ProductPricingRequest extends FormRequest
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
        return $this->createRules() + [
            'site_id' => [
                'int',
                'exists:' . Site::Table() . ',id',
                'nullable',
            ],
            'pricing_rule_id' => ['int', 'exists:' . PricingRule::Table() . ',id', 'nullable'],
            'ordering_rule_id' => ['int', 'exists:' . OrderingRule::Table() . ',id', 'nullable'],
            'status' => ['bool', 'nullable'],
        ];
    }

    public function createRules()
    {
        return [
            'price_reg' => ['numeric','required'],
            'price_sale' => ['numeric', 'nullable','lte:price_reg'],
            'onsale' => ['bool', 'required'],
            'min_qty' => ['numeric', 'nullable','lte:max_qty'],
            'max_qty' => ['numeric','nullable'],
            'feature' => ['bool', 'required'],
        ];
    }
}
