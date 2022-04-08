<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_order_details', function (Blueprint $table) {
            $table->id();
            $table->string('Return_Id');
            $table->integer('Product_Id');
            $table->string('Quantity');
            $table->string('Price');
            $table->string('Tax_Slab');
            $table->string('Tax_Amount');
            $table->string('Sub_Total');
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
        Schema::dropIfExists('return_order_details');
    }
}
