<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOutcomes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outcomes', function (Blueprint $table) {
           $table->increments('id');
           $table->date('trans_date');
           $table->string('store_name');
           $table->string('type_trans');
           $table->string('store_tlp');
           $table->decimal('qty');
           $table->decimal('price_income', 15, 2);
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
