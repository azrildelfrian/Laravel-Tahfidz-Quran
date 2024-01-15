<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Halaqoh extends Model
{
    use HasFactory;
    protected $table = 'halaqoh';
    protected $guarded = ['id'];

    public function ustad()
    {
        return $this->belongsTo(User::class, 'ustad_pengampu');
    }
}
