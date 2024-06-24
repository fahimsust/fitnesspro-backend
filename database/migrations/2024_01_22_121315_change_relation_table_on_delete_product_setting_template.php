<?php

use Domain\Products\Models\Product\Settings\ProductSettings;
use Domain\Products\Models\Product\Settings\ProductSettingsTemplate;
use Domain\Products\Models\Product\Settings\ProductSettingsTemplateModuleValue;
use Domain\Products\Models\Product\Settings\ProductSiteSettings;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(ProductSettings::Table(), function (Blueprint $table) {
            $table->dropForeign(['settings_template_id']);
            $table->foreign('settings_template_id')
                ->references('id')->on(ProductSettingsTemplate::Table())-> nullOnDelete();
        });
        Schema::table(ProductSiteSettings::Table(), function (Blueprint $table) {
            $table->dropForeign(['settings_template_id']);
            $table->foreign('settings_template_id')
                ->references('id')->on(ProductSettingsTemplate::Table())-> nullOnDelete();
        });
        Schema::table(ProductSettingsTemplate::Table(), function (Blueprint $table) {
            $table->dropForeign(['settings_template_id']);
            $table->foreign('settings_template_id')
                ->references('id')->on(ProductSettingsTemplate::Table())-> nullOnDelete();
        });
        Schema::table(ProductSettingsTemplateModuleValue::Table(), function (Blueprint $table) {
            $table->dropForeign('category_setting_template_id');
            $table->foreign('settings_template_id','product_setting_template_id')
                ->references('id')->on(ProductSettingsTemplate::Table())->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
