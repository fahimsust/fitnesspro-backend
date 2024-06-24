<?php

namespace Domain\Products\Actions\BulkEdit\Perform\Error;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Lorisleiva\Actions\Concerns\AsObject;
use Illuminate\Validation\ValidationException;

class GetDiscountLevelError
{
    use AsObject;

    public function handle(
        PerformRequest $request,
    ) {
        $errors = [];
        if (!$request->discount_level_id) {
            $errors['discount_level_id'] = __('Template can\'t be empty');
        }
        if(count($errors) > 0)
        {
            throw ValidationException::withMessages($errors);
        }
    }
}
