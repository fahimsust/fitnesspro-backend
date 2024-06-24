<?php

namespace App\Api\Admin\Orders\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Domain\Addresses\Models\Address;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class CreateOrderAddressRequest extends FormRequest
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
            'address_id' => ['numeric', 'exists:' . Address::Table() . ',id', 'required'],
            'is_billing' => ['boolean', 'required'],
        ];
    }
}
