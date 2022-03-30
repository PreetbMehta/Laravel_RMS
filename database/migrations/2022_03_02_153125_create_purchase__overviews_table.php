<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOverviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase__overviews', function (Blueprint $table) {
            $table->id();
            $table->date('Date_Of_Purchase');
            $table->string('Supplier_Id');
            $table->string('Total_Products');
            $table->string('Sub_Total');
            $table->string('Total_Tax_Amount');
            $table->string('Discount_Amount');
            $table->string('Total_Amount');
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
        Schema::dropIfExists('purchase__overviews');
    }
}
