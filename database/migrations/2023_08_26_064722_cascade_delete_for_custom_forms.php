<?php

use Domain\Accounts\Models\AccountField;
use Domain\Accounts\Models\AccountType;
use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\FormSection;
use Domain\CustomForms\Models\FormSectionField;
use Domain\CustomForms\Models\FormShow;
use Domain\CustomForms\Models\ProductForm;
use Domain\CustomForms\Models\ProductFormType;
use Domain\Orders\Models\Order\OrderCustomForm;
use Domain\Orders\Models\Order\OrderItems\OrderItemCustomField;
use Domain\Products\Models\Wishlist\WishlistItemCustomField;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table(ProductFormType::Table(), function (Blueprint $table) {
            $table->dropForeign(['form_id']);
            $table->foreign('form_id')
                ->references('id')->on(CustomForm::Table())->onDelete('cascade');
        });
        Schema::table(ProductForm::Table(), function (Blueprint $table) {
            $table->dropForeign(['form_id']);
            $table->foreign('form_id')
                ->references('id')->on(CustomForm::Table())->onDelete('cascade');
        });
        Schema::table(AccountField::Table(), function (Blueprint $table) {
            $table->dropForeign(['form_id']);
            $table->foreign('form_id')
                ->references('id')->on(CustomForm::Table())-> nullOnDelete();
        });
        Schema::table(AccountType::Table(), function (Blueprint $table) {
            $table->dropForeign(['custom_form_id']);
            $table->foreign('custom_form_id')
                ->references('id')->on(CustomForm::Table())-> nullOnDelete();
        });
        Schema::table(FormSection::Table(), function (Blueprint $table) {
            $table->dropForeign(['form_id']);
            $table->foreign('form_id')
              ->references('id')->on(CustomForm::Table())->onDelete('cascade');
        });
        Schema::table(FormShow::Table(), function (Blueprint $table) {
            $table->dropForeign(['form_id']);
            $table->foreign('form_id')
              ->references('id')->on(CustomForm::Table())->onDelete('cascade');
        });
        Schema::table(OrderCustomForm::Table(), function (Blueprint $table) {
            $table->dropForeign(['form_id']);
            $table->foreign('form_id')
              ->references('id')->on(CustomForm::Table())->onDelete('cascade');
        });
        Schema::table(OrderItemCustomField::Table(), function (Blueprint $table) {
            $table->dropForeign(['form_id']);
            $table->dropForeign(['section_id']);
            $table->foreign('form_id')
              ->references('id')->on(CustomForm::Table())->onDelete('cascade');
            $table->foreign('section_id')
                ->references('id')->on(FormSection::Table())->onDelete('cascade');

        });
        Schema::table(WishlistItemCustomField::Table(), function (Blueprint $table) {
            $table->dropForeign(['form_id']);
            $table->dropForeign(['section_id']);
            $table->foreign('form_id')
              ->references('id')->on(CustomForm::Table())->onDelete('cascade');
            $table->foreign('section_id')
              ->references('id')->on(FormSection::Table())->onDelete('cascade');
        });

        Schema::table(FormSectionField::Table(), function (Blueprint $table) {
            $table->dropForeign(['section_id']);
            $table->foreign('section_id')
                ->references('id')->on(FormSection::Table())->onDelete('cascade');
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
