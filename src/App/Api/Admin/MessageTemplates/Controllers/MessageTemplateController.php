<?php

namespace App\Api\Admin\MessageTemplates\Controllers;

use App\Api\Admin\MessageTemplates\Requests\MessageTemplateRequest;
use Domain\Accounts\Actions\LoadAccountByIdFromCache;
use Domain\Affiliates\Models\Affiliate;
use Domain\Messaging\Models\MessageTemplate;
use Domain\Orders\Actions\Order\LoadOrderById;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Domain\Sites\Actions\LoadSiteByIdFromCache;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Support\Helpers\HandleMessageKeys;
use Symfony\Component\HttpFoundation\Response;

class MessageTemplateController extends AbstractController
{
    public function index()
    {
        return Response(
            MessageTemplate::all(),
            Response::HTTP_OK
        );
    }

    public function store(MessageTemplateRequest $request)
    {
        return response(
            MessageTemplate::create($request->all()),
            Response::HTTP_CREATED
        );
    }

    public function update(MessageTemplateRequest $request, MessageTemplate $messageTemplate)
    {
        return response(
            $messageTemplate->update($request->all()),
            Response::HTTP_CREATED
        );
    }

    public function show(MessageTemplate $messageTemplate, Request $request)
    {
        return Response(
            ($request->site_id && $request->account_id)
                ? $messageTemplate->replaceKeysUsingHandler(
                    (new HandleMessageKeys())
                        ->when(
                            $request->has('order_id') && $request->order_id > 0,
                            fn ($handler) => $handler->setOrder(
                                LoadOrderById::now($request->order_id)
                            )
                        )
                        ->when(
                            $request->has('shipment_id') && $request->shipment_id > 0,
                            fn ($handler) => $handler->setShipment(
                                Shipment::find($request->shipment_id)
                            )
                        )
                        ->when(
                            $request->has('package_id') && $request->package_id > 0,
                            fn ($handler) => $handler->setPackage(
                                OrderPackage::find($request->package_id)
                            )
                        )
                        ->when(
                            $request->has('site_id') && $request->site_id > 0,
                            fn ($handler) => $handler->setSite(
                                LoadSiteByIdFromCache::now($request->site_id)
                            )
                        )
                        ->when(
                            $request->has('account_id') && $request->account_id > 0,
                            fn ($handler) => $handler->setAccount(
                                LoadAccountByIdFromCache::now($request->account_id)
                            )
                        )
                        ->when(
                            $request->has('affiliate_id') && $request->affiliate_id > 0,
                            fn ($handler) => $handler->setAffiliate(
                                Affiliate::find($request->affiliate_id)
                            )
                        )
                )
                : $messageTemplate,
            Response::HTTP_OK
        );
    }

    public function destroy(MessageTemplate $messageTemplate)
    {
        return Response(
            $messageTemplate->delete(),
            Response::HTTP_OK
        );
    }
}
