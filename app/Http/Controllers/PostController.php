<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Organization;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    /**
     * Liste publique de tous les articles
     */
    public function index(): Response
    {
        $posts = Post::with('organization')
            ->latest()
            ->paginate(12);

        return Inertia::render('Posts', [
            'posts' => $posts->through(fn(Post $post) => [
                'id'           => $post->id,
                'slug'         => $post->slug,
                'title'        => $post->title,
                'summary'      => $post->summary,
                'cover_image'  => $post->cover_image ? asset('storage/' . $post->cover_image) : null,
                'category'     => $post->category,
                'read_time'    => $post->read_time,
                'created_at'   => $post->created_at->translatedFormat('j F Y'),
                'organization' => $post->organization ? [
                    'name' => $post->organization->name,
                    'slug' => $post->organization->slug,
                    'logo' => $post->organization->logo ? asset('storage/' . $post->organization->logo) : null,
                ] : null,
            ]),
        ]);
    }

    /**
     * Page de lecture d'un article
     */
    public function show(string $slug): Response
    {
        $post = Post::with('organization')->where('slug', $slug)->firstOrFail();

        return Inertia::render('Posts/Show', [
            'post' => [
                'id'           => $post->id,
                'slug'         => $post->slug,
                'title'        => $post->title,
                'summary'      => $post->summary,
                'content'      => $post->content,
                'cover_image'  => $post->cover_image ? asset('storage/' . $post->cover_image) : null,
                'category'     => $post->category,
                'read_time'    => $post->read_time,
                'created_at'   => $post->created_at->translatedFormat('j F Y'),
                'organization' => $post->organization ? [
                    'name' => $post->organization->name,
                    'slug' => $post->organization->slug,
                    'logo' => $post->organization->logo ? asset('storage/' . $post->organization->logo) : null,
                ] : null,
            ],
        ]);
    }

    /**
     * Interface de gestion des actualités pour les orgs
     */
    public function dashboard(): Response
    {
        $organization = auth()->user()?->organizations()->first();
        $posts = $organization ? $organization->posts()->latest()->get() : [];

        return Inertia::render('Dashboard/Posts', [
            'posts'        => $posts,
            'organization' => $organization,
        ]);
    }

    /**
     * Créer un article
     */
    public function store(Request $request): RedirectResponse
    {
        $organization = auth()->user()?->organizations()->first();

        if (!$organization) {
            return back()->with('error', 'Organisation non trouvée.');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'summary'     => 'required|string|max:500',
            'content'     => 'required|string',
            'category'    => 'nullable|string|max:100',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('posts/covers', 'public');
        }

        // Calcul automatique du temps de lecture (250 mots/min)
        $wordCount = str_word_count(strip_tags((string)$validated['content']));
        $validated['read_time'] = max(1, (int)round($wordCount / 250));

        $organization->posts()->create($validated);

        return back()->with('success', 'Article publié avec succès.');
    }

    /**
     * Supprimer un article
     */
    public function destroy(Post $post): RedirectResponse
    {
        $organization = auth()->user()?->organizations()->first();

        if (!$organization || $post->organization_id !== $organization->id) {
            abort(403);
        }

        $post->delete();

        return back()->with('success', 'Article supprimé.');
    }
}
