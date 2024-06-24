<?php

namespace App\Api\Admin\Accounts\Requests;

use App\Api\Accounts\Rules\BlackListEmail;
use App\Api\Accounts\Rules\BlackListIP;
use Domain\Accounts\Models\AccountStatus;
use Domain\Affiliates\Models\Affiliate;
use Domain\Photos\Models\Photo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class AccountRequest extends FormRequest
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
            'username' => $this->getUsernameValidation(),
            'email' => $this->getEmailValidation(),
            'password' => ['max:255', 'min:6','nullable'],
            'first_name' => ['string', 'max:55', 'required'],
            'last_name' => ['string', 'max:55', 'required'],
            'phone' => ['string','max:255','nullable'],
            'status_id' => ['numeric', 'exists:' . AccountStatus::Table() . ',id', 'nullable'],
            'affiliate_id' => ['numeric', 'exists:' . Affiliate::Table() . ',id', 'nullable'],
            'photo_id' => ['numeric', 'exists:' . Photo::Table() . ',id', 'nullable'],
            'profile_public' => ['boolean','required'],
            'admin_notes' => ['string', 'nullable'],
        ];
    }
    private function useUsername(): bool
    {
        return config('accounts.account_use_username');
    }

    private function getUsernameValidation(): array
    {
        $validation = ['string', 'max:55', 'required'];

        if ($this->useUsername()) {
            $validation[] = 'unique:accounts,username,'.$this->account->id;;
        }

        return $validation;
    }

    private function getEmailValidation(): array
    {
        $validation = [
            'string',
            'email',
            'max:85',
            'required',
            new BlackListEmail(),
            new BlackListIP(),
        ];

        if (! $this->use_username || config('accounts.dont_allow_duplicate_email')) {
            $validation[] = 'unique:accounts,email,'.$this->account->id;
        }

        return $validation;
    }
}
