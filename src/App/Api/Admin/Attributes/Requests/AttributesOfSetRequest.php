<?php

namespace App\Api\Admin\Attributes\Requests;

use Domain\Products\Models\Attribute\AttributeSet;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class AttributesOfSetRequest extends FormRequest
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
            'set_id' => ['numeric', 'exists:' . AttributeSet::Table() . ',id', 'required'],
        ];
    }
}
