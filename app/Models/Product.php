<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillaable = ['Picture','Reference_Id','Unit','MRP','Name','Category','Quantity','Short_Desc'];
}
