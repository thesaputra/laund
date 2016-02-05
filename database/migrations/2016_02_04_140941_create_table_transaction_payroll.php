<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTransactionPayroll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_payrolls', function (Blueprint $table) {
           $table->increments('id');
           $table->date('payroll_date');
           $table->integer('user_id')->unsigned();
           $table->foreign('user_id')->references('id')->on('users');
           $table->string('depart');
           $table->decimal('gpk', 15, 2);
           $table->decimal('bonus', 15, 2);
           $table->decimal('potongan', 15, 2);
           $table->string('description');
           $table->integer('deleted');
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
