<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Tracker extends Model
{
    use HasFactory;
    public $table = 'product_trackers';

    protected $Fillable = ['Date','Product_Id','Quantity','Type','Purchase_Id','Sales_Id','Return_Id'];
}
