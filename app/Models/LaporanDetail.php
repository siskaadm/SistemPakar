<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanDetail extends Model
{
    use HasFactory;

	protected $fillable = [
		'kode_aturan',
		'kode_kerusakan',
		'kode_kategori',
		'persentase'
	];

	public $timestamps = false;

	public function aturan() {
		return $this->belongsTo(Aturan::class, 'kode_aturan', 'kode_aturan');
	}

	public function kerusakan() {
		return $this->belongsTo(Kerusakan::class, 'kode_kerusakan', 'kode_kerusakan');
	}

	public function kategori() {
		return $this->belongsTo(Kategori::class, 'kode_kategori', 'kode_kategori');
	}

	public function laporan() {
		return $this->belongsTo(Laporan::class, 'laporan_id', 'id');
	}
}
