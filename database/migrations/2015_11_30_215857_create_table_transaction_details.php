<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTransactionDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('transaction_details', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('transaction_id')->unsigned();
          $table->foreign('transaction_id')->references('id')->on('transactions');
          $table->integer('package_id')->unsigned();
          $table->foreign('package_id')->references('id')->on('packages');
          $table->integer('package_type');
          $table->decimal('qty', 15, 2);

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
