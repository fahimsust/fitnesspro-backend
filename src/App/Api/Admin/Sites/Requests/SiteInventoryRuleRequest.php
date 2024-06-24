<?php

namespace App\Api\Admin\Sites\Requests;

use Domain\Sites\Models\InventoryRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SiteInventoryRuleRequest extends FormRequest
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
            'rule_id' => ['numeric', 'exists:' . InventoryRule::Table() . ',id', 'required'],
        ];
    }
}
