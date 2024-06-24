<?php

namespace Domain\Products\Actions\BulkEdit\Perform\Error;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Lorisleiva\Actions\Concerns\AsObject;
use Illuminate\Validation\ValidationException;

class GetPriceError
{
    use AsObject;

    public function handle(
        PerformRequest $request,
    ) {
        $errors = [];
        if (!$request->price_reg) {
            $errors['price_reg'] = __('Price can\'t be empty');
        }
        if (!$request->site_id) {
            $errors['site_id'] = __('Please select a site');
        }
        if ($request->onsale == true && !$request->price_sale) {
            $errors['price_sale'] = __('You must add sale price if product is on sale');
        }
        if(count($errors) > 0)
        {
            throw ValidationException::withMessages($errors);
        }
    }
}
