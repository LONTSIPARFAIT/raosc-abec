<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Notifications\OrganizationStatusChanged;
use Illuminate\Http\Request;

class OrganizationManagementController extends Controller
{
    public function updateStatus(Request $request, Organization $organization)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected,suspended',
            'rejection_reason' => 'required_if:status,rejected|nullable|string|max:1000',
        ]);

        $organization->update([
            'status' => $validated['status'],
            'rejection_reason' => $validated['status'] === 'rejected' ? $validated['rejection_reason'] : null,
            'approved_at' => $validated['status'] === 'approved' ? now() : $organization->approved_at,
        ]);

        // Envoyer la notification au créateur
        if ($organization->creator) {
            $organization->creator->notify(new OrganizationStatusChanged(
                $organization, 
                $validated['status'], 
                $validated['rejection_reason'] ?? null
            ));
        }

        return back()->with('success', 'Le statut de l\'organisation a été mis à jour.');
    }
}
