<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $user = auth()->user();
        
        // Estadísticas generales
        $stats = [
            'total_pets' => Pet::count(),
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'total_clients' => User::role('client')->count(),
            'total_staff' => User::role('staff')->count(),
            'recent_pets' => Pet::with('owner')->latest()->take(5)->get(),
        ];
        
        return view('admin.dashboard', compact('stats', 'user'));
    }
}
