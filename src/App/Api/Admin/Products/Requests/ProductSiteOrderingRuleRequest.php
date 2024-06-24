<?php

namespace App\Api\Admin\Products\Requests;

use Domain\Products\Models\OrderingRules\OrderingRule;
use Domain\Sites\Models\Site;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class ProductSiteOrderingRuleRequest extends FormRequest
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
            'site_id' => [
                'int',
                'exists:' . Site::Table() . ',id',
                'nullable',
            ],
            'ordering_rule_id' => ['int', 'exists:' . OrderingRule::Table() . ',id', 'nullable'],
        ];
    }
}
