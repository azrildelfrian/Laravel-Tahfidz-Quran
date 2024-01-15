<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ustad extends Model
{
    use HasFactory;
    protected $table = 'ustad';
    protected $guarded = ['id'];
}
