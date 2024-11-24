<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VerificationController extends Controller
{
    public function notice()
    {
        return Inertia::render('Auth/VerifyEmail',[
            'message'=>session('message')
        ]);
    }

    public function handler(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('home');
    }
    public function resend(Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    }
}
