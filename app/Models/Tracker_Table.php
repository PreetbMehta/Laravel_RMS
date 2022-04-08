<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracker_Table extends Model
{
    use HasFactory;
    public $table = 'tracker_tables';
    protected $Fillable = ['Date','Cust_Id','Sales_Id','Amount','Type','Payment_Method','Note']; 
}
