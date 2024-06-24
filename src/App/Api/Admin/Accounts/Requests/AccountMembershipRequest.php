<?php

namespace App\Api\Admin\Accounts\Requests;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class AccountMembershipRequest extends FormRequest
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
            'start_date' => ['date', 'required'],
            'end_date' => ['date', 'after:start_date', 'required'],
            'amount_paid' => ['numeric', 'required'],
            'level_id' => ['numeric', 'exists:' . MembershipLevel::Table() . ',id', 'required'],
            'account_id' => ['numeric', 'exists:' . Account::Table() . ',id', 'required'],
        ];
    }
}
