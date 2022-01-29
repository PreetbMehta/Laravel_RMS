<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = ['Supplier_Name','Brand_Name','Address','Contact','Email_Id','GST_No','Account_No','IFSC_Code'];
}
