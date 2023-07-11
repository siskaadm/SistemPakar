<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriSolusi extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_kategori',
        'solusis',
    ];
    protected $casts = [
        'solusis' => 'array',
    ];
    protected $primaryKey = 'kode_kategori';
    protected $keyType = 'string';

    public function solusis() {
		return $this->hasMany(Solusi::class, 'kode_solusi', 'kode_solusi');
	}
}
