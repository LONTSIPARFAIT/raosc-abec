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
            'categories' => OrganizationCategoryResource::collection($categories)->resolve(),
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
            'categories' => OrganizationCategoryResource::collection($categories)->resolve()
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
            'website' => 'nullable|url|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'country' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'registration_number' => 'nullable|string|max:255',
            'founded_date' => 'nullable|date',
            'categories' => 'required|array',
            'categories.*' => 'exists:organization_categories,id',
            'logo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery' => 'required|array|min:1',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $organizationData = collect($validated)->except(['categories', 'logo', 'gallery'])->toArray();
        $organization = new Organization($organizationData);
        $organization->user_id = auth()->id();
        $organization->slug = Str::slug($validated['name']) . '-' . uniqid();
        $organization->status = 'pending'; // Doit être validé par un modérateur/admin ABEC
        
        if ($request->hasFile('logo')) {
            $organization->logo = $request->file('logo')->store('organizations/logos', 'public');
        }

        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $image) {
                $galleryPaths[] = $image->store('organizations/gallery', 'public');
            }
            $organization->gallery = $galleryPaths;
        }

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

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Organization $organization)
    {
        // On s'assure que seul l'admin/fondateur peut modifier
        abort_if(! $organization->members()->where('user_id', auth()->id())->exists(), 403);

        $categories = OrganizationCategory::all();

        return Inertia::render('Rao/Edit', [
            'organization' => new OrganizationResource($organization->load('categories')),
            'categories' => OrganizationCategoryResource::collection($categories)->resolve()
        ]);
    }

    /**
     * Affiche la liste des organisations de l'utilisateur connecté
     */
    public function myOrganizations(Request $request)
    {
        $organizations = Organization::whereHas('members', function($q) {
            $q->where('user_id', auth()->id());
        })->orWhere('user_id', auth()->id())->get();

        return Inertia::render('Rao/MyOrganizations', [
            'organizations' => OrganizationResource::collection($organizations)->resolve()
        ]);
    }

    /**
     * Met à jour l'organisation
     */
    public function update(Request $request, Organization $organization)
    {
        abort_if(! $organization->members()->where('user_id', auth()->id())->exists(), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'description' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'country' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'registration_number' => 'nullable|string|max:255',
            'founded_date' => 'nullable|date',
            'categories' => 'required|array',
            'categories.*' => 'exists:organization_categories,id',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $organizationData = collect($validated)->except(['categories', 'logo', 'gallery'])->toArray();

        if ($request->hasFile('logo')) {
            $organizationData['logo'] = $request->file('logo')->store('organizations/logos', 'public');
        }

        if ($request->hasFile('gallery')) {
            $galleryPaths = $organization->gallery ?? [];
            foreach ($request->file('gallery') as $image) {
                $galleryPaths[] = $image->store('organizations/gallery', 'public');
            }
            $organizationData['gallery'] = $galleryPaths;
        }

        $organization->update($organizationData);
        $organization->categories()->sync($validated['categories']);

        return redirect()->route('dashboard')
            ->with('success', 'Organisation mise à jour avec succès.');
    }
}

