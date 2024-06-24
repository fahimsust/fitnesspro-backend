<?php

use Domain\Products\Models\Category\CategorySettings;
use Domain\Products\Models\Category\CategorySettingsTemplate;
use Domain\Products\Models\Category\CategorySettingsTemplateModuleValue;
use Domain\Products\Models\Category\CategorySiteSettings;
use Domain\Products\Models\Product\Settings\ProductSettingsTemplateModuleValue;
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
        Schema::table(CategorySettings::Table(), function (Blueprint $table) {
            $table->dropForeign(['settings_template_id']);
            $table->foreign('settings_template_id')
                ->references('id')->on('categories_settings_templates')-> nullOnDelete();
        });
        Schema::table(CategorySiteSettings::Table(), function (Blueprint $table) {
            $table->dropForeign(['settings_template_id']);
            $table->foreign('settings_template_id')
                ->references('id')->on('categories_settings_templates')-> nullOnDelete();
        });
        Schema::table(CategorySettingsTemplate::Table(), function (Blueprint $table) {
            $table->dropForeign(['settings_template_id']);
            $table->foreign('settings_template_id')
                ->references('id')->on('categories_settings_templates')-> nullOnDelete();
        });
        Schema::table(CategorySettingsTemplateModuleValue::Table(), function (Blueprint $table) {
            $table->dropForeign('set_tmp_id');
            $table->foreign('settings_template_id','set_tmp_id')
                ->references('id')->on('categories_settings_templates')->onDelete("cascade");
        });
        Schema::table(ProductSettingsTemplateModuleValue::Table(), function (Blueprint $table) {
            $table->dropForeign('category_setting_template_id');
            $table->foreign('settings_template_id','category_setting_template_id')
                ->references('id')->on('categories_settings_templates')->onDelete("cascade");
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
