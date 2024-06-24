<?php

namespace App\Api\Admin\Categories\Requests;

use Domain\Products\Models\Attribute\AttributeOption;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class CategoryCondtionRuleRequest extends FormRequest
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
            'matches' => ['bool', 'required'],
            'value_id' => ['numeric', 'exists:' . AttributeOption::Table() . ',id', 'required'],
        ];
    }
}
