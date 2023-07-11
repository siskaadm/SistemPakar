<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kerusakan extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_kerusakan',
        'nama_kerusakan',
        'kode_kategori',
    ];
    protected $primaryKey = 'kode_kerusakan';
    protected $keyType = 'string';

    public function aturans() {
        return $this->belongsTo(Aturan::class, 'kode_aturan', 'kode_aturan');
    }
}

