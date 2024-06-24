<?php

namespace App\Api\Admin\OrderingRules\Requests;

use Domain\Products\Enums\OrderingConditionTypes;
use Domain\Products\Models\OrderingRules\OrderingRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;
use Worksome\RequestFactories\Concerns\HasFactory;

class OrderingConditionRequest extends FormRequest
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
            'rule_id' => ['numeric', 'exists:' . OrderingRule::Table() . ',id', 'required'],
            'type' => ['string',new Enum(OrderingConditionTypes::class),'required'],
        ];
    }
}
