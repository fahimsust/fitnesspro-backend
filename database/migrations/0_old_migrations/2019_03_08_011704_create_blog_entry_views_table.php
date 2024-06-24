<?php

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
        Schema::create('blog_entry_views', function (Blueprint $table) {
            $table->integer('entry_id');
            $table->integer('account_id');
            $table->date('viewed_date');
            $table->time('viewed_time');
            $table->index(['entry_id', 'account_id'], 'blev_entry_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_entry_views');
    }
};
