<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
class VerificationController extends Controller
{
    public function notice(){
        return Inertia::render('Auth/VerifyEmail');
    }
}
