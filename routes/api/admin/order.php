<?php

use App\Api\Admin\Orders\Controllers\AbandonedOrdersController;
use App\Api\Admin\Orders\Controllers\MoveOrderItemController;
use App\Api\Admin\Orders\Controllers\OrderAccountController;
use App\Api\Admin\Orders\Controllers\OrderActivityController;
use App\Api\Admin\Orders\Controllers\OrderAddressController;
use App\Api\Admin\Orders\Controllers\OrderAffiliateController;
use App\Api\Admin\Orders\Controllers\OrderCustomFormController;
use App\Api\Admin\Orders\Controllers\OrderDiscountController;
use App\Api\Admin\Orders\Controllers\OrderEmailController;
use App\Api\Admin\Orders\Controllers\OrderItemController;
use App\Api\Admin\Orders\Controllers\OrderItemDiscountController;
use App\Api\Admin\Orders\Controllers\OrderItemNoteController;
use App\Api\Admin\Orders\Controllers\OrderNotesController;
use App\Api\Admin\Orders\Controllers\OrderPackageController;
use App\Api\Admin\Orders\Controllers\OrderReferralController;
use App\Api\Admin\Orders\Controllers\OrdersController;
use App\Api\Admin\Orders\Controllers\OrderStatusController;
use App\Api\Admin\Orders\Controllers\OrderTransactionsController;
use App\Api\Admin\Orders\Controllers\RemoveOrderItemController;
use App\Api\Admin\Orders\Controllers\SendOrderEmailController;
use App\Api\Admin\Orders\Controllers\ShipmentController;
use App\Api\Admin\Orders\Controllers\ShipmentPrintController;
use App\Api\Admin\Orders\Controllers\ShipmentStatusController;
use Illuminate\Support\Facades\Route;

Route::apiResource('orders', OrdersController::class);
Route::apiResource('abandoned-orders', AbandonedOrdersController::class);
Route::apiResource('order-status', OrderStatusController::class)->only(['index']);
Route::apiResource('shipment-status', ShipmentStatusController::class)->only(['index']);
Route::prefix('order/{order}')->as('order.')->group(function () {
    Route::apiResource('shipment', ShipmentController::class)->only(['store', 'destroy', 'update']);
    Route::apiResource('discount', OrderDiscountController::class)->only(['store', 'destroy']);
    Route::apiResource('activity', OrderActivityController::class)->only(['index']);
    Route::apiResource('custom-forms', OrderCustomFormController::class)->only(['index', 'update']);
    Route::apiResource('note', OrderNotesController::class)->only(['index', 'store']);
    Route::post('address', OrderAddressController::class)->name('address');
    Route::post('remove-affiliate', OrderAffiliateController::class)->name('remove-affiliate');
    Route::post('send-mail', SendOrderEmailController::class)->name('send-mail');
    Route::apiResource('transaction', OrderTransactionsController::class)->only(['index', 'store']);
    Route::apiResource('email', OrderEmailController::class)->only(['index']);
    Route::apiResource('affiliate', OrderReferralController::class)->only(['index', 'store', 'destroy']);
    Route::apiResource('account', OrderAccountController::class)
        ->only(['update', 'destroy']);
});
Route::apiResource('shipment-print', ShipmentPrintController::class)->only(['show']);
Route::prefix('shipment/{shipment}')->as('shipment.')->group(function () {
    Route::apiResource('order-package', OrderPackageController::class)->only(['store', 'destroy', 'update']);
});
Route::prefix('package/{package}')->as('package.')->group(function () {
    Route::apiResource('item', OrderItemController::class)->only(['store', 'destroy', 'update']);
    Route::post('delete-items', RemoveOrderItemController::class)->name("delete-items");
    Route::prefix('item/{item}')->as('item.')->group(function () {
        Route::post('move', MoveOrderItemController::class)->name("move");
    });
});
Route::prefix('order-item/{order_item}')->as('order-item.')->group(function () {
    Route::post('note', OrderItemNoteController::class)->name("note");
});
Route::prefix('discount/{discount}')->as('discount.')->group(
    function () {
        Route::apiResource('item', OrderItemDiscountController::class)->only(['store', 'destroy']);
    }
);
