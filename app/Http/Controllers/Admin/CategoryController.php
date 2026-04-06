<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = OrganizationCategory::withCount('organizations')->latest()->get();
        return inertia('Admin/Categories', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:organization_categories,name',
            'description' => 'required|string'
        ]);
        
        $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        
        OrganizationCategory::create($validated);
        return back()->with('success', 'Catégorie créée avec succès');
    }

    public function destroy(OrganizationCategory $category)
    {
        if ($category->organizations()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer cette catégorie car elle contient des organisations');
        }
        $category->delete();
        return back()->with('success', 'Catégorie supprimée avec succès');
    }
}
