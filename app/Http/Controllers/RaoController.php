<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\OrganizationCategory;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\OrganizationCategoryResource;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class RaoController extends Controller
{
    /**
     * Affiche l'annuaire des organisations (RAO).
     * Les données sont retournées sous forme de ressource (JsonResource)
     * pour garantir une structure uniforme côté Frontend.
     */
    public function index(Request $request)
    {
        $query = Organization::with('categories')
            ->where('status', 'approved');

        // Filtre par texte (nom)
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%");
        }

        // Filtre par Pays
        if ($request->filled('country')) {
            $query->where('country', $request->get('country'));
        }

        // Filtre par Ville
        if ($request->filled('city')) {
            $query->where('city', $request->get('city'));
        }

        // Filtre par catégorie
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->get('category'));
            });
        }

        $organizations = $query->latest()->paginate(12)->withQueryString();
        $categories = OrganizationCategory::all();

        return Inertia::render('Rao/Index', [
            'organizations' => OrganizationResource::collection($organizations),
            'categories' => OrganizationCategoryResource::collection($categories),
            'filters' => $request->only(['search', 'category', 'city', 'country']),
            'isPublic' => ! $request->is('dashboard*') && ! $request->is('settings*')
        ]);
    }

    /**
     * Affiche le profil détaillé public d'une organisation.
     */
    public function show(Request $request, $slug)
    {
        $organization = Organization::with(['categories', 'members.user'])
            ->where('slug', $slug)
            ->where('status', 'approved')
            ->firstOrFail();

        return Inertia::render('Rao/Show', [
            'organization' => new OrganizationResource($organization),
            'isPublic' => ! $request->is('dashboard*') && ! $request->is('settings*')
        ]);
    }

    /**
     * Affiche le formulaire d'enregistrement au réseau.
     */
    public function create()
    {
        $categories = OrganizationCategory::all();

        return Inertia::render('Rao/Create', [
            'categories' => OrganizationCategoryResource::collection($categories)
        ]);
    }

    /**
     * Traite la soumission d'une nouvelle organisation.
     * Cette organisation sera mise en attente (pending) par défaut.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'description' => 'nullable|string',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'country' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'registration_number' => 'nullable|string|max:255',
            'founded_date' => 'nullable|date',
            'categories' => 'required|array',
            'categories.*' => 'exists:organization_categories,id',
        ]);

        $organization = new Organization($validated);
        $organization->user_id = auth()->id();
        $organization->slug = Str::slug($validated['name']) . '-' . uniqid();
        $organization->status = 'pending'; // Doit être validé par un modérateur/admin ABEC
        $organization->save();

        // Liaison avec les catégories choisies
        $organization->categories()->attach($validated['categories']);

        // Le créateur devient automatiquement administrateur de son organisation
        $organization->members()->create([
            'user_id' => auth()->id(),
            'role' => 'admin',
            'job_title' => 'Fondateur / Dirigeant'
        ]);

        return redirect()->route('rao.index')
        ->with('success', 'Votre organisation a été soumise avec succès. Elle est en cours d\'examen.');
    }
}

