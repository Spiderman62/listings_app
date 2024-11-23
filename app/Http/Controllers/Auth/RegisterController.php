<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RegisterController extends Controller
{
    public function create(Request $request)
    {
        return Inertia::render('Auth/Register', []);
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|min:3|max:30',
            'email' => 'email|required|max:255',
            'password' => 'required|min:3|max:255|confirmed',
        ]);
        $user = User::create($credentials);
        event(new Registered($user));
        return redirect()->route('login');
    }
}
