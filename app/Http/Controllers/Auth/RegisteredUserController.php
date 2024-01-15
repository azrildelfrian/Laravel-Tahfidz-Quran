<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Santri;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Halaqoh;
use App\Models\Kelas;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $halaqoh = Halaqoh::all();
        $kelas = Kelas::all();
        
        return view('auth.register', compact('halaqoh', 'kelas'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'role' => 'required|in:admin,ustad,santri',
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string',
            'password' => 'required|string|min:6',
            'halaqoh_id' => $request->role === 'santri' ? 'required' : '',
            'kelas_id' => $request->role === 'santri' ? 'required' : '',
            'nomor_id' => $request->role === 'santri' ? 'required' : '',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        if ($request->role === 'admin') {
            // Logika atau kode khusus untuk akun admin
            // Misalnya, membuat entri di tabel admin, dll.
            
            // Event untuk akun admin
            event(new Registered($user));
        } elseif ($request->role === 'ustad') {
            // Logika atau kode khusus untuk akun ustad
            // Misalnya, membuat entri di tabel ustad, dll.
            
            // Event untuk akun ustad
            event(new Registered($user));
        } elseif ($request->role === 'santri') {
            $santri = Santri::create([
                'id_santri' => $user->id,
                'halaqoh_id' => $request->halaqoh_id,
                'kelas_id' => $request->kelas_id,
                'nomor_id' => $request->nomor_id,
            ]);

            // Event untuk akun santri
            event(new Registered($user, $santri));

            // Gunakan dd untuk melihat data akun santri
        }

        // Gunakan dd untuk melihat data akun
        // dd($user);

        return redirect(RouteServiceProvider::HOME);
    }


}
