<?php

namespace App\Api\Admin\Sites\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;
use Illuminate\Validation\Rule;

class AllowOrderingOfRequest extends FormRequest
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
            'cart_allowavailability' => ['array','nullable'],
            'cart_orderonlyavailableqty' => ['boolean','required'],
            'cart_addtoaction' => ['int','required', Rule::in([0,1]),],
        ];
    }
}
