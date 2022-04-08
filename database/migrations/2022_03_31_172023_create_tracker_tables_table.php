<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackerTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracker_tables', function (Blueprint $table) {
            $table->id();
            $table->date('Date');
            $table->integer('Cust_Id');
            $table->integer('Sales_Id');
            $table->double('Amount');
            $table->integer('Type');
            $table->string('Payment_Method');
            $table->text('Note');
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
        Schema::dropIfExists('tracker__tables');
    }
}
