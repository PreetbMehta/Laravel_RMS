<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnOrderOverviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_order_overviews', function (Blueprint $table) {
            $table->id();
            $table->date('Date_Of_Return');
            $table->integer('Customer_Id');
            $table->integer('Sales_Id');
            $table->string('Total_SubTotal');
            $table->string('Total_TaxAmount');
            $table->string('Discount_Per');
            $table->string('Discount_Amount');
            $table->string('Amount_Returned');
            $table->string('Return_Method');
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
        Schema::dropIfExists('return_order_overviews');
    }
}
