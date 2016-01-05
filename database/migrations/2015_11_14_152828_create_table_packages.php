<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePackages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('packages', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name',100);
          $table->decimal('regular_price',15,2);
          $table->decimal('express_price',15,2);
          $table->decimal('opr_price',15,2);
          $table->string('unit',50);
          $table->string('description',200);

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
