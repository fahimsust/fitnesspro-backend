<?php

use Domain\Orders\Models\Order\OrderCustomForm;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::table(OrderCustomForm::Table(), function (Blueprint $table) {
            $table->renameColumn('form_values', 'form_values_old');
        });

        Schema::table(OrderCustomForm::Table(), function (Blueprint $table) {
            $table->json('form_values')->nullable();
        });

//        OrderCustomForm::query()
//            ->select('id', 'form_values')
//            ->lazy()
//            ->each(function (OrderCustomForm $orderCustomForm) {
//                if (!$orderCustomForm->form_values) {
//                    return;
//                }
//
//                if (is_array($orderCustomForm->form_values)) {
//                    $orderCustomForm->save();
//
//                    return;
//                }
//
//                $jsonDecoded = html_entity_decode($orderCustomForm->form_values);
//                $json = json_decode($jsonDecoded, true);
//
//                if ($json !== null) {
//                    $orderCustomForm->form_values = $json;
//                    $orderCustomForm->save();
//                }
//            });

        $orderCustomForms = DB::table('orders_customforms')
            ->select('id', 'form_values_old')
            ->whereNull('form_values')
            ->get();
        foreach ($orderCustomForms as $orderCustomForm) {
            if ($orderCustomForm->form_values_old) {
                $jsonDecoded = html_entity_decode($orderCustomForm->form_values_old);
                $json = json_decode($jsonDecoded, true);
                if ($json !== null) {
                    OrderCustomForm::query()
                        ->where('id', $orderCustomForm->id)
                        ->update(['form_values' => $json]);
//                    $orderCustomForm->form_values = $json;
//                    $orderCustomForm->save();
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
