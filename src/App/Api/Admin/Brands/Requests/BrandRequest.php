<?php

namespace App\Api\Admin\Brands\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class BrandRequest extends FormRequest
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
    public function name_rule()
    {
        $validation = ['string','max:55', 'required'];
        if (isset($this->brand->id)) {
            $validation[] = 'unique:brands,name,'.$this->brand->id;
        } else {
            $validation[] = 'unique:brands';
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
            'name' => $this->name_rule(),
        ];
    }
}