<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

	protected $fillable = [
		'user_id',
		'no_hp',
		'tahun_motor',
		'persentase',
		'pilihan_gejalas',
	];

	protected $casts = [
		'pilihan_gejalas' => 'array',
	];

	public function user() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function details() {
		return $this->hasMany(LaporanDetail::class, 'laporan_id', 'id');
	}

	public function getCreatedAtAttribute() {
		return \Carbon\Carbon::parse($this->attributes['created_at'])
			->translatedFormat('d F Y');
	}
}
