<?php

namespace App\Http\Controllers\Santri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SantriC extends Controller
{
    public function dashboard()
    {
        if(Auth::user()->role === 'admin'){
            return redirect()->route('admin.dashboard');
        } elseif(Auth::user()->role === 'ustad'){
            return redirect()->route('ustad.dashboard-ustad');
        }   
        return view('dashboard');
    }
}
