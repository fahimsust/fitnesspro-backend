<?php

namespace App\Api\Admin\CustomForms\Controllers;

use App\Api\Admin\CustomForms\Requests\CreateSectionFieldRequest;
use App\Api\Admin\CustomForms\Requests\CustomFieldRequest;
use Domain\CustomForms\Models\CustomField;
use Domain\CustomForms\Models\FormSectionField;
use Support\Controllers\AbstractController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomFieldController extends AbstractController
{
    public function index(Request $request)
    {
        return response(
            CustomField::query()
                ->basicKeywordSearch($request->keyword)
                ->where('status',true)
                ->when(
                    $request->filled('order_by'),
                    fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
                )
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
    public function store(CreateSectionFieldRequest $request)
    {
        return response(
            FormSectionField::create([
                'section_id'=> $request->section_id,
                'field_id'=> $request->field_id,
                'required'=> 0,
                'rank'=> 0,
                'new_row'=> 0,
            ]),
            Response::HTTP_CREATED
        );
    }
    public function show(int $customFieldId)
    {
        return response(
            CustomField::where('id',$customFieldId)->with('options')->first(),
            Response::HTTP_CREATED
        );
    }

    public function update(CustomField $customField, CustomFieldRequest $request)
    {
        return response(
            $customField->update([
                'name' => $request->name,
                'status' => $request->status,
                'display' => $request->display,
                'required' => $request->required,
                'type' => $request->type,
                'cssclass'=>$request->cssclass,
                'specs'=>$request->specs,
            ]),
            Response::HTTP_CREATED
        );
    }
}
