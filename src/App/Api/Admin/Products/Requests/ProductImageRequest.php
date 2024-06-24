<?php

namespace App\Api\Admin\Products\Requests;

use App\Rules\IsCompositeUnique;
use Domain\Content\Models\Image;
use Domain\Products\Models\Product\ProductImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class ProductImageRequest extends FormRequest
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
            'image_id' => [
                'int',
                'exists:' . Image::Table() . ',id',
                'required',
                new IsCompositeUnique(
                    ProductImage::Table(),
                    [
                        'image_id' => $this->image_id,
                        'product_id' => $this->product_id,
                    ],
                    $this->id
                ),
            ],
        ] + (new UpdateProductImageRequest())->rules();
    }
}
