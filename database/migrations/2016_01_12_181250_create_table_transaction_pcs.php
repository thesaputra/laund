<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTransactionPcs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('transaction_pcs', function (Blueprint $table) {
           $table->increments('id');
           $table->integer('transaction_id')->unsigned();
           $table->foreign('transaction_id')->references('id')->on('transactions');
           $table->integer('user_id')->unsigned();
           $table->foreign('user_id')->references('id')->on('users');
           $table->integer('package_id')->unsigned();
           $table->foreign('package_id')->references('id')->on('packages');
           $table->string('package_detail');
           $table->integer('package_type');
           $table->string('unit');
           $table->integer('qty');
           $table->decimal('price', 15, 2);
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
