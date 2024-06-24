<?php

use Domain\Sites\Models\Site;
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
        Schema::table(Site::Table(), function (Blueprint $table) {
            $table->string('required_account_types',100)->nullable()->change();
        });
        $sites = Site::all();
        foreach($sites as $site)
        {
            $required_account_types = null;
            if($site->required_account_types)
            {
                $required_account_types = json_encode(explode("|",$site->required_account_types));
            }
            Site::where('id',$site->id)->update([
                'required_account_types'=> $required_account_types,
            ]);
        }
        Schema::table(Site::Table(), function (Blueprint $table) {
            $table->text('offline_message')->nullable()->change();
            $table->boolean('status')->default(1)->change();
            $table->integer('offline_key')->default(null)->nullable()->change();
            $table->boolean('require_login')->default(0)->change();
            $table->bigInteger('account_type_id')->default(null)->nullable()->change();
            $table->json('required_account_types')->nullable()->change();
            $table->string('version',25)->nullable()->change();
            $table->string('template_set',55)->nullable()->change();
            $table->string('logo_url',255)->nullable()->change();
            $table->bigInteger('theme_id')->default(null)->nullable()->change();
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
