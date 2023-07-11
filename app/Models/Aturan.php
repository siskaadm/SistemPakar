<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aturan extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_aturan',
        'kode_gejala',
        'kode_kerusakan',
    ];
    protected $casts = [
        'kode_gejala' => 'array',
    ];
    protected $primaryKey = 'kode_aturan';
    protected $keyType = 'string';

    public function gejalas() {
        return $this->hasMany(Gejala::class, 'kode_gejala', 'kode_gejala');
    }

	public function kerusakans() {
		return $this->hasOne(Kerusakan::class, 'kode_kerusakan', 'kode_kerusakan');
	}
}
