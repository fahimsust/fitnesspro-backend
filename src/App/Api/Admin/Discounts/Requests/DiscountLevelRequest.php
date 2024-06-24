<?php

namespace App\Api\Admin\Discounts\Requests;

use Domain\Discounts\Enums\DiscountLevelActionType;
use Domain\Discounts\Enums\DiscountLevelApplyTo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;
use Illuminate\Validation\Rules\Enum;

class DiscountLevelRequest extends FormRequest
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
            'name' => ['string', 'max:55', 'required'],
            'apply_to' => [
                'numeric',
                new Enum(DiscountLevelApplyTo::class),
                'required'
            ],
            'action_type' => [
                'numeric',
                new Enum(DiscountLevelActionType::class),
                'required'
            ],
            'action_sitepricing' => ['int', 'nullable'],
            'action_percentage' => ['nullable', 'numeric'],
            'status' => ['boolean', 'required'],
        ];
    }
}
