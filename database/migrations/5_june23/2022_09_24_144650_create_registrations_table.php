<?php

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Affiliates\Models\Affiliate;
use Domain\Payments\Models\PaymentMethod;
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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('account_id')->constrained(Account::Table());
            $table->tinyInteger('status')->default(1);
            $table->string('recovery_hash', 255)->nullable();
            $table->foreignId('level_id')->nullable()->constrained(MembershipLevel::Table());
            $table->foreignId('payment_method_id')->nullable()->constrained(PaymentMethod::Table());
            $table->foreignId('affiliate_id')->nullable()->constrained(Affiliate::Table());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registrations');
    }
};
