<?php

namespace Domain\Products\Actions\BulkEdit\Perform\Error;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Lorisleiva\Actions\Concerns\AsObject;
use Illuminate\Validation\ValidationException;

class GetKeywordReplaceError
{
    use AsObject;

    public function handle(
        PerformRequest $request,
    ) {
        $errors = [];
        if (!$request->keyword) {
            $errors['keyword'] = __('Keyword can\'t be empty');
        }
        if (!$request->column) {
            $errors['column'] = __('Field name can\'t be empty');
        }
        if (!$request->replace) {
            $errors['replace'] = __('Replace value can\'t be empty');
        }
        if(count($errors) > 0)
        {
            throw ValidationException::withMessages($errors);
        }
    }
}
