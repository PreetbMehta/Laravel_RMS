<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase_Overview extends Model
{
    use HasFactory;

    protected $table = 'purchase_overviews';

    protected $fillable = ['Date_Of_Purchase','Supplier_Id','Total_Products','Sub_Total','Total_Tax_Amount','Discount_Amount','Total_Amount'];
}
