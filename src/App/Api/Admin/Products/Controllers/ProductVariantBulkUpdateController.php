<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\BulkProductDistributorRequest;
use App\Api\Admin\Products\Requests\BulkProductDistributorStockQuantityRequest;
use App\Api\Admin\Products\Requests\BulkProductImageRequest;
use App\Api\Admin\Products\Requests\BulkProductOutOfStockRequest;
use App\Api\Admin\Products\Requests\BulkProductStatusRequest;
use Domain\Products\Actions\Product\ProductBulkUpdate;
use Domain\Products\Actions\Product\ProductBulkUpdateDistributorQuantity;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductVariantBulkUpdateController extends AbstractController
{
    public function status(BulkProductStatusRequest $request)
    {
        return response(
            ProductBulkUpdate::run($request,'status'),
            Response::HTTP_OK
        );
    }
    public function outOfStock(BulkProductOutOfStockRequest $request)
    {
        return response(
            ProductBulkUpdate::run($request,'default_outofstockstatus_id'),
            Response::HTTP_OK
        );
    }
    public function image(BulkProductImageRequest $request)
    {
        return response(
            ProductBulkUpdate::run($request,'details_img_id'),
            Response::HTTP_OK
        );
    }
    public function defaultDistributor(BulkProductDistributorRequest $request)
    {
        return response(
            ProductBulkUpdate::run($request,'default_distributor_id'),
            Response::HTTP_OK
        );
    }
    public function distributorStockQuantity(BulkProductDistributorStockQuantityRequest $request)
    {
        return response(
            ProductBulkUpdateDistributorQuantity::run($request),
            Response::HTTP_OK
        );
    }

}
