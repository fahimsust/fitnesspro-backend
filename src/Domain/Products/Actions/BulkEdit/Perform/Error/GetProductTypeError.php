<?php

namespace Domain\Products\Actions\BulkEdit\Perform\Error;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Lorisleiva\Actions\Concerns\AsObject;
use Illuminate\Validation\ValidationException;

class GetProductTypeError
{
    use AsObject;

    public function handle(
        PerformRequest $request,
    ) {
        $errors = [];
        if (!$request->product_type_id) {
            $errors['product_type_id'] = __('Product type can\'t be empty');
        }
        if(count($errors) > 0)
        {
            throw ValidationException::withMessages($errors);
        }
    }
}
