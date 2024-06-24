<?php

namespace App\Api\Admin\OrderingRules\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;
use Support\Enums\MatchAllAnyString;
use Worksome\RequestFactories\Concerns\HasFactory;

class OrderingConditionUpdateRequest extends FormRequest
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
            'any_all' => ['string',new Enum(MatchAllAnyString::class), 'required'],
        ];
    }
}
