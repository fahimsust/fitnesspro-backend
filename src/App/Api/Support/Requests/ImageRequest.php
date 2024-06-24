<?php

namespace App\Api\Support\Requests;

use Domain\Support\Models\TmpFile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;
use Worksome\RequestFactories\Concerns\HasFactory;

class ImageRequest extends FormRequest
{
    use HasFactory;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'image' => ['integer', 'required', 'exists:' . TmpFile::table() . ',id'],
            'name' => ['string', 'max: 100', 'required'],
            'default_caption' => ['string', 'max: 100', 'nullable'],
            'inventory_image_id' => ['string', 'max: 100', 'nullable'],
        ];
    }
}
