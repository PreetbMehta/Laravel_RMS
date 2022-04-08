<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnOrder_Overview extends Model
{
    use HasFactory;
    public $table = 'return_order_overviews';

    protected $Fillable = ['Date_Of_Sale','Customer_Id','Sales_Id','Total_SubTotal','Total_TaxAmount','Discount_Per','Discount_Amount','Amount_Returned','Return_Method'];
}
