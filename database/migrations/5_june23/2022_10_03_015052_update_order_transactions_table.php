<?php

use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(OrderTransaction::Table(), function (Blueprint $table) {
            $table->string('transaction_no', 35)->nullable()->change();
            $table->string('cc_no', 4)->nullable()->change();
            $table->text('notes')->nullable()->change();
            $table->timestamp('created')->useCurrent()->change();
            $table->timestamp('updated')->nullable()->useCurrentOnUpdate()->change();
            $table->renameColumn('voided_date', 'voided_at');

            $table->dropForeign('orders_transactions_gateway_account_id_foreign');
            $table->foreign('gateway_account_id')
                ->on(\Domain\Payments\Models\PaymentAccount::Table())
                ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
