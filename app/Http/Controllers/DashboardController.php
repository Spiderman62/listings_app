<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

class DashboardController extends Controller
{
    private array $data = [];
    public function index(){
        $this->data['listings'] = request()->user()->role !== 'suspended' ? request()->user()->listings()->latest()->paginate(6) : null;
        $this->data['status'] = session('status');
        return Inertia::render('Dashboard',$this->data);
    }
}
