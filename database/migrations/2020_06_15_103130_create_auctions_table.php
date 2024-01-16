<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('ref_id');
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('address_id')->nullable();
            $table->integer('auction_type');
            $table->bigInteger('category_id')->unsigned();
            $table->string('currency_symbol');
            $table->date('starting_date');
            $table->date('ending_date');
            $table->date('delivery_date')->nullable();
            $table->integer('bid_initial_price');
            $table->integer('bid_increment_dif')->nullable();
            $table->text('product_description');
            $table->text('images')->nullable();
            $table->integer('is_shippable');
            $table->integer('shipping_type');
            $table->text('shipping_description')->nullable();
            $table->text('terms_description')->nullable();
            $table->integer('status')->default(AUCTION_STATUS_DRAFT);
            $table->integer('product_claim_status')->nullable()->default(AUCTION_PRODUCT_CLAIM_STATUS_NOT_DELIVERED_YET);
            $table->integer('is_multiple_bid_allowed');
            $table->decimal('system_fee',13,2)->default(0);
            $table->text('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();
            $table->timestamps();

            $table->foreign('seller_id')
                ->references('id')
                ->on('sellers')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('currency_symbol')
                ->references('symbol')
                ->on('currencies')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('address_id')
                ->references('id')
                ->on('addresses')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auctions');
    }
}
