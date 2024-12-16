<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class AdminController extends Controller
{
    private array $data = [];

    public function index()
    {
        $this->data['users'] = User::with('listings')
            ->filter(request(['search', 'user_role']))
            ->paginate(4)
            ->withQueryString();
        $this->data['status'] = session('status');
        return Inertia::render('Admin/AdminDashboard', $this->data);
    }

    public function role(Request $request, User $user)
    {
        Gate::authorize('modifyRole', $user);
        $request->validate([
            'role' => 'required|string'
        ]);
        $user->update([
            'role' => $request->role
        ]);
        return redirect()->back()->with('status', "User: $user->name role changed to $request->role role successfully");
    }

    public function show(User $user)
    {
        $this->data['user'] = $user;
        $this->data['user_listings'] = $user
            ->listings()
            ->filter(request(['search', 'disapproved']))
            ->latest()
            ->paginate(10)
            ->withQueryString();
        $this->data['status'] = session('status');
        return Inertia::render('Admin/UserPage', $this->data);
    }

    public function approve(Listing $listing)
    {
        Gate::authorize('approve', $listing);
        $listing->update([
            'approved' => !$listing->approved
        ]);
        $msg = $listing->approved ? 'approved' : 'disapproved';
        return back()->with('status', "Listing $msg successfully changed!");
    }
}
