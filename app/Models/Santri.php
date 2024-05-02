<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;
    protected $table = 'santri';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_santri');
    }

    public function halaqoh()
    {
        return $this->belongsTo(Halaqoh::class, 'halaqoh_id');
    }

    public function ustad()
    {
        return $this->belongsTo(User::class, 'ustad_pengampu');
    }
}
