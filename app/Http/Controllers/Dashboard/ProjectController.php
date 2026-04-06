<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $organization = auth()->user()->organizations()->first();
        
        if (!$organization) {
            return redirect()->route('dashboard')->with('error', 'Vous devez d\'abord créer une organisation.');
        }

        $projects = $organization->projects()->latest()->get();

        return inertia('Dashboard/Projects', [
            'projects' => $projects,
            'organization' => $organization
        ]);
    }

    public function store(Request $request)
    {
        $organization = auth()->user()->organizations()->first();
        
        if (!$organization) {
            return back()->with('error', 'Organisation non trouvée.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:projet,benevolat',
            'description' => 'required|string',
            'status' => 'required|in:active,completed',
            // cover_image handling can be added later if needed
        ]);

        $organization->projects()->create($validated);

        return back()->with('success', 'Élément ajouté avec succès.');
    }

    public function destroy(\App\Models\Project $project)
    {
        // Add auth validation logic here if necessary
        $project->delete();
        return back()->with('success', 'Élément supprimé avec succès.');
    }
}
