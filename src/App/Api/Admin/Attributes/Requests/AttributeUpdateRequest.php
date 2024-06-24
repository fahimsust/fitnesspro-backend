<?php

namespace App\Api\Admin\Attributes\Requests;

use Domain\Products\Models\Attribute\AttributeType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class AttributeUpdateRequest extends FormRequest
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
            'name' => ['string','max:55','required'],
            'type_id' => ['numeric', 'exists:' . AttributeType::Table() . ',id', 'required'],
            'show_in_details' => ['bool','required'],
            'show_in_search' => ['bool','required'],
        ];
    }
}
