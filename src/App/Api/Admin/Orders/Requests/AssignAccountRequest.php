<?php

namespace App\Api\Admin\Orders\Requests;

use Domain\Accounts\Models\Account;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class AssignAccountRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $this->merge([
            'account_id' => $this->route('account'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'account_id' => ['int', 'exists:' . Account::Table() . ',id', 'required'],
        ];
    }
}
