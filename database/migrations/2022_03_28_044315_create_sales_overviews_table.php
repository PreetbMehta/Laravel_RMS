<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesOverviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_overviews', function (Blueprint $table) {
            $table->id();
            $table->date('Date_Of_Sale');
            $table->string('Customer_Id');
            $table->string('Total_Products');
            $table->string('Total_SubTotal');
            $table->string('Total_Tax_Amount');
            $table->string('Discount_Per');
            $table->string('Discount_Amount');
            $table->string('Total_Amount');
            $table->string('Payment_Method');
            $table->string('Amount_Paid');
            $table->string('Returning_Change');
            $table->string('Card_BankName');
            $table->string('Card_OwnerName');
            $table->string('Card_Number');
            $table->string('UPI_WalletName');
            $table->string('UPI_TransactionId');
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
        Schema::dropIfExists('sales__overviews');
    }
}
