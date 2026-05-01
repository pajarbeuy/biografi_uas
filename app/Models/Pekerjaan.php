<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    protected $table = 'pekerjaan';
    
    protected $fillable = [
        'nama_pekerjaan',
        'deskripsi_pekerjaan',
        'nama_perusahaan',
    ];
}
