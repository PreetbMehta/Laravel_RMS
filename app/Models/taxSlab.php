<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class taxSlab extends Model
{
    use HasFactory;
    protected $fillable = ['TaxPercentage'];
}
