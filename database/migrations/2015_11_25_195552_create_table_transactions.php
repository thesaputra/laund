<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('transactions', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('customer_id')->unsigned();
          $table->foreign('customer_id')->references('id')->on('customers');
          $table->integer('user_id')->unsigned();
          $table->foreign('user_id')->references('id')->on('users');
          $table->integer('status_id')->unsigned();
          $table->foreign('status_id')->references('id')->on('status');
          $table->string('invoice_number');
          $table->date('date_order');
          $table->date('date_deliver');
          $table->time('time_deliver');
          $table->decimal('amount_dp', 15, 2);
          $table->decimal('amount_left', 15, 2);
          $table->decimal('discount', 15, 2);
          $table->string('description', 200);
          $table->string('rack_info', 200);
          $table->date('date_checkout');
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
        Schema::drop('transactions');
    }
}
