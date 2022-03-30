<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales_Details extends Model
{
    use HasFactory;
    public $table = 'sales_details';

    protected $Fillable = ['Sales_Id','Sales_Product','Sales_Quantity','Sales_Price','SalesTaxSlab','SalesTaxAmount','SalesSubTotal'];
}
