<?php

namespace App\Api\Admin\Products\Types\Requests;

use Domain\Tax\Models\TaxRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductTypeTaxRuleRequest extends FormRequest
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
            'rule_ids' => [
                'array',
                'nullable'
            ],
            'rule_ids.*' => [
                'int',
                'exists:' . TaxRule::Table() . ',id',
                'nullable'
            ],
        ];
    }
}
