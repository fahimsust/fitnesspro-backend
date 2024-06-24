<?php

use Domain\Resorts\Models\Resort;
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
        Schema::table('mods_resort_details', function (Blueprint $table) {
            foreach ($this->columns() as $column) {
                $table->string($column, 25)->nullable();
            }
        });
    }

    private function columns()
    {
        return [
            'fee_entertainment',
            'fee_admin',
            'fee_gift',
            'fee_airtravel',
            'fee_transfers',
            'fee_companion',
        ];
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mods_resort_details', function (Blueprint $table) {
            $table->dropColumn($this->columns());
        });
    }
};
