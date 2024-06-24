<?php

namespace Domain\Products\Actions\BulkEdit\Perform\Error;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\Concerns\AsObject;

class GetWeightError
{
    use AsObject;

    public function handle(
        PerformRequest $request,
    )
    {
        $errors = [];

        if (!$request->weight) {
            $errors['weight'] = __('Weight can\'t be empty');
        }

        if (!is_numeric($request->weight)) {
            $errors['weight'] = __('Weight must be numeric');
        }

        if (count($errors) > 0) {
            throw ValidationException::withMessages($errors);
        }
    }
}
