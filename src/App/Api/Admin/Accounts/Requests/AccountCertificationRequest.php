<?php

namespace App\Api\Admin\Accounts\Requests;

use Domain\Accounts\Models\Account;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class AccountCertificationRequest extends FormRequest
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
            'account_id' => ['numeric', 'exists:' . Account::Table() . ',id', 'nullable'],
            'cert_num' => ['string', 'max:35', 'required'],
            'cert_type' => ['string', 'max:55', 'required'],
            'cert_org' => ['string', 'max:55', 'required'],
            'file_name' => ['required', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
            'approval_status' => ['boolean', 'required'],
            'cert_exp' => ['date', 'nullable']
        ];
    }
}
