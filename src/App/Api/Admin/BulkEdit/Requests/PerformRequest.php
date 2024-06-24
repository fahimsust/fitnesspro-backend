<?php

namespace App\Api\Admin\BulkEdit\Requests;

use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Product\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Worksome\RequestFactories\Concerns\HasFactory;
use Illuminate\Validation\Rules\Enum;

class PerformRequest extends FormRequest
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
            'ids' => [
                'array',
                'required',
            ],
            'ids.*' => [
                'int',
                Rule::exists(Product::Table(), 'id')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'action_name' => ['string',new Enum(ActionList::class),'required'],
        ];
    }
}
