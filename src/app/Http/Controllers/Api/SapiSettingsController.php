<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SapiSettingsController extends Controller
{
    public function index()
    {
        return view('settings.login');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|min:2',
            'password' => 'required|string|min:2',
        ]);

        session([
            'sapi_username' => $request->username,
            'sapi_password' => $request->password,
        ]);

        return redirect('/')
            ->with('success', 'SAPI beállítás sikeres!');
    }
}
