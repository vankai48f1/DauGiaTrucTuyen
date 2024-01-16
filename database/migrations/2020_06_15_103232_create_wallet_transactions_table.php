<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('currency_symbol');
            $table->unsignedBigInteger('bank_account_id')->nullable();
            $table->integer('txn_type');
            $table->integer('payment_method')->nullable();
            $table->unsignedBigInteger('wallet_id');
            $table->decimal('amount', 13, 2);
            $table->integer('status');
            $table->string('address')->nullable();
            $table->string('payment_txn_id')->unique()->nullable();
            $table->string('ref_id');
            $table->decimal('network_fee',13,2)->default(0);
            $table->decimal('system_fee',13,2)->default(0);
            $table->string('receipt', 100)->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
            $table->foreign('wallet_id')
                ->references('id')
                ->on('wallets')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('bank_account_id')
                ->references('id')
                ->on('bank_accounts')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->foreign('currency_symbol')
                ->references('symbol')
                ->on('currencies')
                ->onDelete('restrict')
                ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet_transactions');
    }
}
