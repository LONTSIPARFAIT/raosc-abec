<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        
        return Inertia::render('Admin/Users', [
            'users' => $users
        ]);
    }

    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin,user',
        ]);

        if ($user->id === auth()->id() && $validated['role'] !== 'admin') {
            return back()->with('error', 'Vous ne pouvez pas retirer vos propres droits d\'administrateur.');
        }

        $user->update(['role' => $validated['role']]);

        return back()->with('success', 'Rôle de l\'utilisateur mis à jour avec succès.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte depuis cette interface.');
        }

        $user->delete();

        return back()->with('success', 'Utilisateur supprimé avec succès.');
    }
}
