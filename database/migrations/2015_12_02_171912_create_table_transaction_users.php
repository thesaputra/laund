<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTransactionUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('transaction_users', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('transaction_id')->unsigned();
          $table->foreign('transaction_id')->references('id')->on('transactions');
          $table->integer('user_id')->unsigned();
          $table->foreign('user_id')->references('id')->on('users');
          $table->integer('package_id')->unsigned();
          $table->foreign('package_id')->references('id')->on('packages');
          $table->integer('qty');
          $table->string('unit');
          $table->datetime('start_date');
          $table->datetime('end_date');
          $table->string('status');

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
