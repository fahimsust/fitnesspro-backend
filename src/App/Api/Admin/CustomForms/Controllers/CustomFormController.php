<?php

namespace App\Api\Admin\CustomForms\Controllers;

use App\Api\Admin\CustomForms\Requests\CustomFormRequest;

use Domain\CustomForms\Actions\DeleteCustomForm;
use Domain\CustomForms\Models\CustomForm;
use Support\Controllers\AbstractController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomFormController extends AbstractController
{
    public function index(Request $request)
    {
        return response(
            CustomForm::query()
                ->availableToAssignToProduct($request->product_id,$request->keyword)
                ->where('id', '!=', $request->product_id)
                ->when(
                    $request->filled('order_by'),
                    fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
                )
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
    public function store(CustomFormRequest $request)
    {
        return response(
            CustomForm::Create([
                'name' => $request->name,
                'status' => $request->status
            ]),
            Response::HTTP_CREATED
        );
    }

    public function update(CustomForm $customForm, CustomFormRequest $request)
    {
        $customForm->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);
        return response(
            $customForm->refresh(),
            Response::HTTP_CREATED
        );
    }

    public function show(CustomForm $customForm)
    {
        return response(
            $customForm,
            Response::HTTP_OK
        );
    }

    public function destroy(CustomForm $customForm)
    {
        return response(
            DeleteCustomForm::run($customForm),
            Response::HTTP_OK
        );
    }
}
