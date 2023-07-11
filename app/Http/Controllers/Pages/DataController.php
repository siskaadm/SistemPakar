<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Gejala;
use App\Models\Kerusakan;
use Illuminate\Http\Request;

class DataController extends Controller
{
	public function index()
	{
		$gejalas = Gejala::all();
		$kerusakans = Kerusakan::all();
		return view('pages.data', compact('gejalas', 'kerusakans'));
	}
}
