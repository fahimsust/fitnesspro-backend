<?php

namespace App\Api\Admin\Products\Requests;

use Domain\Content\Models\Image;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class BulkProductImageRequest extends BulkProductRequest
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
            'details_img_id' => [
                'int',
                'exists:' . Image::Table() . ',id',
                'required'
            ],
        ]+parent::rules();
    }
}
