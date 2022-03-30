<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_details', function (Blueprint $table) {
            $table->id();
            $table->string("Sales_Id");
            $table->string("Sales_Product");
            $table->string("Sales_Quantity");
            $table->string("Sales_Price");
            $table->string("SalesTaxSlab");
            $table->string("SalesTaxAmount");
            $table->string("SalesSubTotal");
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
        Schema::dropIfExists('sales__details');
    }
}
