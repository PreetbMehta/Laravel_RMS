<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillaable = ['Picture','Reference_Id','Cost_Price','MRP','Purchase_no','Category','Quantity','Short_Desc'];
}
