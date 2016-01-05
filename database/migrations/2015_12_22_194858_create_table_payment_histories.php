<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePaymentHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('payment_histories', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('transaction_id')->unsigned();
          $table->foreign('transaction_id')->references('id')->on('transactions');
          $table->decimal('amount', 15, 2);
          $table->string('description');

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
        //
    }
}
