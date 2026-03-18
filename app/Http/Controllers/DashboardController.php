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

        // Organisations en attente de validation (pour l'admin)
        $pendingOrgsList = Organization::where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();
            
        // Data for Charts
        $categoriesStats = \App\Models\OrganizationCategory::withCount(['organizations' => function($query) {
            $query->where('status', 'approved');
        }])->get();

        $chartData = [
            'categories' => [
                'labels' => $categoriesStats->pluck('name'),
                'datasets' => [
                    [
                        'label' => 'OSC par catégorie',
                        'data' => $categoriesStats->pluck('organizations_count'),
                        'backgroundColor' => ['#008751', '#FFCB05', '#310808', '#004225', '#7F6B00', '#F9FAFB'],
                    ]
                ]
            ],
            'registrations' => [
                'labels' => ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'],
                'datasets' => [
                    [
                        'label' => 'Inscriptions',
                        'data' => [12, 19, 3, 5, 2, 3], // Dummy for now
                        'borderColor' => '#008751',
                        'tension' => 0.4,
                    ]
                ]
            ]
        ];

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'userOrganization' => $userOrganization,
            'recentOrgs' => $recentOrgs,
            'pendingOrgsList' => $pendingOrgsList,
            'chartData' => $chartData
        ]);
    }
}
