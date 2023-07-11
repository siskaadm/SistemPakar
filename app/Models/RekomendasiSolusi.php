<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekomendasiSolusi extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_solusi',
        'deskripsi_solusi',
    ];
    protected $primaryKey = 'kode_solusi';
    protected $keyType = 'string';
}
