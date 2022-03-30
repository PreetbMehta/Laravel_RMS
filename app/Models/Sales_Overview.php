<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales_Overview extends Model
{
    use HasFactory;
    public $table = 'sales_overviews';

    protected $Fillable=['Date_Of_Sale','Customer_Id','Total_Products','Total_SubTotal','Total_Tax_Amount','Discount_Per','Discount_Amount','Total_Amount','Payment_Method','Amount_Paid','Returning_Change','Card_BankName','Card_OwnerName','Card_Number','UPI_WalletName','UPI_TransactionId'];
}
