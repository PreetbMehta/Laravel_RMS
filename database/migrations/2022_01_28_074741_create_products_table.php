<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('Picture');
            $table->string('Reference_Id');
            $table->string('Name');
            $table->string('Category');
            $table->string('Unit');
            $table->string('TaxSlab');
            $table->double('MRP');
            $table->bigInteger('Quantity');
            $table->text('Short_Desc');
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
        Schema::dropIfExists('products');
    }
}
