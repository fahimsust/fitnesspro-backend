<?php

namespace App\Api\Admin\Orders\Controllers;

use App\Api\Admin\CustomForms\Requests\CustomFormRequest;
use App\Api\Admin\Orders\Requests\OrderCustomFormRequest;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderCustomForm;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class OrderCustomFormController extends AbstractController
{
    public function index(Request $request,Order $order)
    {
        return response(
            OrderCustomForm::whereOrderId($order->id)
                ->with(
                    'form',
                    'form.sections',
                    'form.sections.fields',
                    'form.sections.fields.options',
                    'product',
                    'productType'
                )
                ->when(
                    $request->filled('order_by'),
                    fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc'),
                    fn ($query) => $query->orderBy('created', 'DESC')
                )
                ->paginate(),
            Response::HTTP_OK
        );
    }
    public function update(Order $order, OrderCustomForm $customForm, OrderCustomFormRequest $request)
    {
        return response(
            $customForm->update(
                [
                    'form_id' => $request->form_id,
                    'product_id' => $request->product_id,
                    'product_type_id' => $request->product_type_id,
                    'form_values' => $request->form_values
                ]
            ),
            Response::HTTP_CREATED
        );
    }
}
