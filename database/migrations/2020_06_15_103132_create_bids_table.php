<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->bigInteger('auction_id')->unsigned();
            $table->string('currency_symbol');
            $table->decimal('amount', 13, 2);
            $table->integer('is_winner')->nullable()->default(ACTIVE_STATUS_INACTIVE);
            $table->decimal('system_fee',13,2)->default(0);
            $table->timestamps();

            $table->foreign('auction_id')->references('id')->on('auctions')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('bids');
    }
}
