<?php

namespace App\Api\Admin\OrderingRules\Requests;

use App\Rules\ExistsInModels;
use Domain\Accounts\Models\AccountType;
use Domain\Accounts\Models\Specialty;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class OrderingConditionItemRequest extends FormRequest
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
            'item_id' => ['numeric', 'required',new ExistsInModels([Specialty::Table(),AccountType::Table()])],
        ];
    }
}
