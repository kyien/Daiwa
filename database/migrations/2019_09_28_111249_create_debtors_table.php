<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDebtorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debtors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Fullnames');
            $table->string('nickname_company', 30);
            $table->integer('Amount_owed')->unsigned();
            $table->string('Mobile_no')->unique();
            $table->string('type_of_debt');
            $table->integer('debt_age')->unsigned();
            $table->integer('users_id')->unsigned();
            $table->string('listing_option');
            $table->string('code');
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('token_users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('debtors');
    }
}
