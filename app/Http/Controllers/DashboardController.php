<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    function index()
    {
        $title = 'Dashboard';
        if (Session::get('type') == 'admin') {
            return view('backend.dashboard-admin', compact('title'));
        } elseif (Session::get('type') == 'petani') {
            return view('backend.dashboard-petani', compact('title'));
        } else {
            return  redirect('/');
        }
    }
}
