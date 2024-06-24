<?php

namespace App\Api\Admin\Products\Requests;

use Domain\Distributors\Models\Distributor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class ProductBasicsRequest extends FormRequest
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
    public function urlRule()
    {
        $validation = ['string','regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', 'max:255', 'required'];
        if (isset($this->product->id)) {
            $validation[] = 'unique:products,url_name,'.$this->product->id;
        } else {
            $validation[] = 'unique:products';
        }
        return $validation;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['string', 'required'],
            'subtitle' => ['string', 'max:255', 'nullable'],
            'url_name' => $this->urlRule(),
            'product_no' => ['string', 'max:155', 'nullable'],
            'weight' => ['int', 'nullable'],
            'default_distributor_id' => [
                'int',
                'exists:' . Distributor::Table() . ',id',
                'nullable',
            ],
        ];
    }
}
