<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase_Detail extends Model
{
    use HasFactory;
    protected $table = 'purchase_details'
    ;
    protected $fillable = ['Purchase_Id','Product_Id','Price','Quantity','Tax_Slab','Tax_Amount','Sub_Total'];
}
