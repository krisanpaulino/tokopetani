<?php

namespace App\Http\Controllers;

use App\Models\Pembeli;
use Illuminate\Http\Request;

class PembeliController extends Controller
{
    function index()
    {
        $title = 'Data Pembeli';
        $pembeli = Pembeli::all();
        return view('backend.pembeli_index', compact('pembeli', 'title'));
    }
}
