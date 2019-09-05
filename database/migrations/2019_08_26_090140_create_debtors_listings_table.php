<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDebtorsListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debtors_listings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Fullnames');
            $table->string('nickname_company', 30);
            $table->integer('Amount_owed')->unsigned();
            $table->string('Mobile_no', 13);
            $table->string('type_of_debt');
            $table->integer('debt_age')->unsigned();
            $table->integer('users_id')->unsigned();
            // $table->foreign('users_id')->references('id')->on('users');
            $table->set('listing_option',['20','40','60','100']);
            $table->string('code');
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
        Schema::dropIfExists('debtors_listings');
    }
}
