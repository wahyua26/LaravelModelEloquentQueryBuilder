<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\DB;

class PenggunaController extends Controller
{
    public function index()
    {
    	// mengambil semua data pengguna
    	//$pengguna = Pengguna::all();
		$pengguna = DB::table('pengguna')->get();
    	// return data ke view
    	return view('pengguna', ['pengguna' => $pengguna]);
    }
}
