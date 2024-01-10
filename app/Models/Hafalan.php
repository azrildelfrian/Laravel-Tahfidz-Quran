<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hafalan extends Model
{
    use HasFactory;

    protected $table = 'hafalan';
    protected $guarded = ['id'];
    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];

    public function surat_1()
    {
        return $this->belongsTo(Surat::class, 'surat_id');
    }

    public function surat_2()
    {
        return $this->belongsTo(Surat::class, 'surat_id_2');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ustad()
    {
        return $this->belongsTo(User::class, 'diperiksa_oleh');
    }
}
