<?php

use Domain\Accounts\Models\Registration\Registration;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
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
        Schema::create('registration_discounts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('registration_id')->constrained(Registration::Table());
            $table->foreignId('discount_id')->constrained(Discount::Table());
            $table->foreignId('advantage_id')->constrained(DiscountAdvantage::Table());
            $table->decimal('amount', 15);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regsitration_discounts');
    }
};
