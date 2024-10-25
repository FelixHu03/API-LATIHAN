<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Pendaftaran extends Model
{
    use HasFactory,HasApiTokens;

    protected $table = 'pendaftaran';

    protected $fillable = [
        'nama',
        'email',
        'nomor_telepon',
        'tingkat_sekolah',
    ];
}
