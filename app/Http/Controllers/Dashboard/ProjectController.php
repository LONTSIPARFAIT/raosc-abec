<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $organization = auth()->user()->organizations()->first();
        
        $projects = $organization ? $organization->projects()->latest()->get() : [];

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
            'cover_image' => 'nullable|image|max:2048',
            'gallery' => 'nullable|array|max:10',
            'gallery.*' => 'image|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('projects/covers', 'public');
        }

        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $image) {
                $galleryPaths[] = $image->store('projects/gallery', 'public');
            }
            $validated['gallery'] = $galleryPaths;
        }

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
