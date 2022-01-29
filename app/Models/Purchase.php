<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = ['Date_Of_Purchase', 'Supplier_Id', 'Supplier_Name','Quantity','Total_Bill_Amount','GST_Amount'];
}
