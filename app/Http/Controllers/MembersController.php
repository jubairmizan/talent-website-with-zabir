<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class MembersController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        $members = User::where('role', 'member')
            ->where('status', 'active');

        // Apply search filter if query has at least 2 characters
        if (strlen($query) >= 2) {
            $members->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%')
                  ->orWhere('email', 'LIKE', '%' . $query . '%');
            });
        }

        // Get all members (no limit for now, or set a reasonable limit like 100)
        $results = $members->orderBy('name')->get();

        $suggestions = $results->map(function ($member) {
            // Determine online status: online if last_login_at is within last 5 minutes
            $isOnline = false;
            if ($member->last_login_at) {
                $isOnline = $member->last_login_at->gt(now()->subMinutes(5));
            }

            return [
                'id' => $member->id,
                'name' => $member->name,
                'profession' => $member->email,
                'image' => $member->avatar
                    ? asset('storage/' . $member->avatar)
                    : asset('images/default-avatar.svg'),
                'url' => '#', // TODO: Add member profile route if needed
                'online' => $isOnline,
            ];
        });

        return response()->json($suggestions);
    }
}