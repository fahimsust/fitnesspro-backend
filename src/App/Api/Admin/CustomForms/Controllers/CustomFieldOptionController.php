<?php

namespace App\Api\Admin\CustomForms\Controllers;

use App\Api\Admin\CustomForms\Requests\CustomFieldOptionRequest;
use Domain\CustomForms\Models\CustomFieldOption;
use Support\Controllers\AbstractController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomFieldOptionController extends AbstractController
{
    public function index(Request $request)
    {
        return response(
            CustomFieldOption::where('field_id',$request->field_id)->get(),
            Response::HTTP_OK
        );
    }
    public function store(CustomFieldOptionRequest $request)
    {
        return response(
            CustomFieldOption::Create([
                'display' => $request->display,
                'value' => $request->value,
                'field_id'=>$request->field_id
            ]),
            Response::HTTP_CREATED
        );
    }

    public function update(CustomFieldOption $customFieldOption, CustomFieldOptionRequest $request)
    {
        return response(
            $customFieldOption->update([
                'display' => $request->display,
                'value' => $request->value,
                'rank' => $request->rank,
                'field_id'=>$request->field_id
            ]),
            Response::HTTP_CREATED
        );
    }

    public function destroy(CustomFieldOption $customFieldOption)
    {
        return response(
            $customFieldOption->delete(),
            Response::HTTP_OK
        );
    }
}
