<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('symbol')->unique();
            $table->string('type', 20);
            $table->string('logo')->nullable();
            $table->integer('is_active');
            $table->decimal('deposit_fee', 13, 2)->unsigned()->default(0);
            $table->string('deposit_fee_type', 20)->default(FEE_TYPE_FIXED);
            $table->integer('deposit_status')->default(INACTIVE);
            $table->decimal('min_deposit', 19, 8)->default(0);
            $table->decimal('withdrawal_fee', 13, 2)->unsigned()->default(0);
            $table->string('withdrawal_fee_type', 20)->default(FEE_TYPE_FIXED);
            $table->integer('withdrawal_status')->default(INACTIVE);
            $table->decimal('min_withdrawal', 19, 8)->default(0);
            $table->json('payment_methods')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
}
