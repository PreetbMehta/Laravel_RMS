<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase__details', function (Blueprint $table) {
            $table->id();
            $table->integer('Purchase_Id');
            $table->string('Product_Id');
            $table->integer('Price');
            $table->integer('Quantity');
            $table->integer('Tax_Slab');
            $table->integer('Tax_Amount');
            $table->integer('Sub_Total');
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
        Schema::dropIfExists('purchase__details');
    }
}
