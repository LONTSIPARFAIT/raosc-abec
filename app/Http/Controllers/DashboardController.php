<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Stats globales pour l'admin (ou juste pour l'affichage)
        $stats = [
            'total_orgs' => Organization::where('status', 'approved')->count(),
            'pending_orgs' => Organization::where('status', 'pending')->count(),
            'total_users' => User::count(),
            'my_orgs' => Organization::where('user_id', $user->id)->count(),
        ];

        // L'organisation de l'utilisateur (s'il en a une)
        $userOrganization = Organization::with('categories')
            ->where('user_id', $user->id)
            ->first();

        // Activités récentes (ex: nouvelles orgs approuvées)
        $recentOrgs = Organization::where('status', 'approved')
            ->latest()
            ->take(5)
            ->get();

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'userOrganization' => $userOrganization,
            'recentOrgs' => $recentOrgs,
        ]);
    }
}
