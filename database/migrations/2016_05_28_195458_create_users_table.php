<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('assigned_role');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->integer('is_address_verified')->nullable();
            $table->integer('is_id_verified')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->boolean('is_email_verified')->default(INACTIVE);
            $table->boolean('is_financial_active')->default(ACTIVE);
            $table->boolean('is_accessible_under_maintenance')->default(INACTIVE);
            $table->boolean('is_super_admin')->default(INACTIVE);
            $table->string('status', 20)->default(STATUS_ACTIVE);
            $table->rememberToken();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('assigned_role')
                ->references('slug')
                ->on('roles')
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
        Schema::drop('users');
    }
}
