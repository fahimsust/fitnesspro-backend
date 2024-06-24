<?php

use Domain\Locales\Models\Language;
use Domain\Products\Models\OrderingRules\OrderingRule;
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
        Schema::create('ordering_rule_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rule_id');
            $table->unsignedBigInteger('language_id');
            $table->string('name',85);
            $table->unique(['rule_id','language_id']);
            $table->foreign('rule_id')
                ->references('id')->on(OrderingRule::Table())->onDelete('cascade');
            $table->foreign('language_id')
                ->references('id')->on(Language::Table())->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordering_rule_translation');
    }
};
