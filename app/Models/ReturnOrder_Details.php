<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnOrder_Details extends Model
{
    use HasFactory;
    public $table = 'return_order_details';

    protected $Fillable = ['Return_Id','Product_Id','Quantity','Price','Tax_Slab','Tax_Amount','Sub_Total'];
}
