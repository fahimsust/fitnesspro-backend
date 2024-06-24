<?php

use Domain\Modules\Models\ModuleTemplate;
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
        Schema::table(ModuleTemplate::Table(), function (Blueprint $table) {
            $table->dropForeign('modules_templates_parent_template_id_foreign');
            $table->foreign('parent_template_id')
                ->references('id')->on(ModuleTemplate::Table())
                ->nullOnDelete()
                ->change();
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
