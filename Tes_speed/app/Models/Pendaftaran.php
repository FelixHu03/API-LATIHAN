<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Pendaftaran extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'pendaftarans';
    protected $fillable = [
        'nama',
        'email',
        'nomorTelepon',
        'tingkatSekolah',
    ];
}
