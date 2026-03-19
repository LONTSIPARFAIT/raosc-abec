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

        // Real data for registrations (last 6 months)
        $monthsLabels = collect();
        $registrationsData = collect();

        for ($i = 5; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subMonths($i);
            $monthsLabels->push($date->translatedFormat('M'));
            // count all requested registrations for this month (or approved, depending on need - we will use all creations)
            $count = Organization::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $registrationsData->push($count);
        }

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
                'labels' => $monthsLabels->toArray(),
                'datasets' => [
                    [
                        'label' => 'Inscriptions',
                        'data' => $registrationsData->toArray(),
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
