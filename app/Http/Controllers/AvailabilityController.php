<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AvailabilityController extends Controller
{
    /**
     * Check if a creator is available for chat
     */
    public function checkCreatorAvailability(Request $request, $creatorId)
    {
        try {
            $creator = User::where('id', $creatorId)
                ->where('role', 'creator')
                ->where('status', 'active')
                ->first();

            if (!$creator) {
                return response()->json([
                    'success' => false,
                    'available' => false,
                    'message' => 'Creator not found or inactive'
                ]);
            }

            // For now, assume all active creators are available
            // In the future, this could check:
            // - Creator's online status
            // - Business hours
            // - Do not disturb settings
            // - Maximum concurrent conversations
            
            return response()->json([
                'success' => true,
                'available' => true,
                'creator' => [
                    'id' => $creator->id,
                    'name' => $creator->name,
                    'status' => 'online' // This could be dynamic
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error checking creator availability: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'available' => false,
                'message' => 'Error checking availability'
            ], 500);
        }
    }

    /**
     * Get current user's availability status
     */
    public function getUserAvailability()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            return response()->json([
                'success' => true,
                'available' => $user->status === 'active',
                'status' => $user->status === 'active' ? 'online' : 'offline',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->role
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting user availability: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error getting availability status'
            ], 500);
        }
    }
}