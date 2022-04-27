<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    public $table = 'settings';

    protected $Fillable = ['Logo','Company_Name','Mobile_No','Email_Id','Address'];
}
