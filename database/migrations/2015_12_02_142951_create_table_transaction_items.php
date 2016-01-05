<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTransactionItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('transaction_items', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('transaction_id')->unsigned();
          $table->foreign('transaction_id')->references('id')->on('transactions');
          $table->integer('item_id')->unsigned();
          $table->foreign('item_id')->references('id')->on('items');
          $table->integer('qty');

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
