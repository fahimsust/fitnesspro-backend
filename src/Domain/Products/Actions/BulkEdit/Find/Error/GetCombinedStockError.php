<?php

namespace Domain\Products\Actions\BulkEdit\Find\Error;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Lorisleiva\Actions\Concerns\AsObject;
use Illuminate\Validation\ValidationException;

class GetCombinedStockError
{
    use AsObject;

    public function handle(
        FindRequest $request,
    ) {
        $errors = [];
        if ($request->min !== 0 && !$request->min) {
            $errors['min'] = __('Min value can\'t be empty');
        }
        if (!is_numeric($request->min)) {
            $errors['min'] = __('Min value must be a number');
        }
        if (!$request->max) {
            $errors['max'] = __('Max value can\'t be empty');
        }
        if (!is_numeric($request->max)) {
            $errors['max'] = __('Max value must be a number');
        }
        if ($request->max < $request->min) {
            $errors['max'] = __('Max value must be greater then min value');
        }
        if(count($errors) > 0)
        {
            throw ValidationException::withMessages($errors);
        }
    }
}
