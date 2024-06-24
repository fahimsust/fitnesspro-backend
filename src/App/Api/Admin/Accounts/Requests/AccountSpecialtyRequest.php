<?php

namespace App\Api\Admin\Accounts\Requests;

use App\Api\Addresses\Requests\AddressRequest;
use Domain\Accounts\Models\Specialty;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class AccountSpecialtyRequest extends AddressRequest
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
            'specialty_id' => ['numeric', 'exists:' . Specialty::Table() . ',id', 'nullable'],
            'approved' => ['boolean', 'required'],
        ];
    }
}
