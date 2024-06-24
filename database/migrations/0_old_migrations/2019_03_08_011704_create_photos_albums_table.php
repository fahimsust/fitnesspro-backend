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
        Schema::create('photos_albums', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 100);
            $table->text('description');
            /*
            if($albumType == 1) $name = "My Photos";
            else if($albumType == 2) $name = "Product/attribute Photos";
            else if($albumType == 3) $name = "Group Photos";
            else if($albumType == 4) $name = "Article Photos";
            else if($albumType == 5) $name = "Events Photos";
            else if($albumType == 6) $name = "Blog Photos";
            else if($albumType == 7) $name = "Advertising Photos";
            */
            $table->tinyInteger('type');
            $table->integer('type_id');
            $table->integer('recent_photo_id');
            $table->dateTime('updated');
            $table->integer('photos_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photos_albums');
    }
};
