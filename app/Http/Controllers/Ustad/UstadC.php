<?php

namespace App\Http\Controllers\Ustad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UstadC extends Controller
{
    public function index()
    {
        return view('ustad.dashboard-ustad');
    }
}
