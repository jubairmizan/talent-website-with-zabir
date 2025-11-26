<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\CreatorProfile;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FavoriteController extends Controller
{
    /**
     * Toggle favorite status for a creator profile
     */
    public function toggle(Request $request, $creatorProfileId): JsonResponse
    {
        try {
            $user = $request->user();

            // Only members can favorite creators
            if ($user->role !== 'member') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only members can favorite creators'
                ], 403);
            }

            // Check if creator profile exists
            $creatorProfile = CreatorProfile::find($creatorProfileId);
            if (!$creatorProfile) {
                return response()->json([
                    'success' => false,
                    'message' => 'Creator profile not found'
                ], 404);
            }

            // Check if already favorited
            $favorite = Favorite::where('user_id', $user->id)
                ->where('creator_profile_id', $creatorProfileId)
                ->first();

            if ($favorite) {
                // Remove from favorites
                $favorite->delete();
                $isFavorited = false;
                $message = 'Removed from favorites';
            } else {
                // Add to favorites
                Favorite::create([
                    'user_id' => $user->id,
                    'creator_profile_id' => $creatorProfileId
                ]);
                $isFavorited = true;
                $message = 'Added to favorites';
            }

            return response()->json([
                'success' => true,
                'is_favorited' => $isFavorited,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating favorites'
            ], 500);
        }
    }
}
