<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\MemberProfile;
use App\Models\User;
use App\Models\Favorite;
use App\Models\CreatorProfile;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function index()
    {
        $userStats = [
            'totalBookings' => 12,
            'completedBookings' => 8,
            'pendingBookings' => 3,
            'cancelledBookings' => 1,
            'totalSpent' => 1850,
            'savedCreators' => 24,
            'reviews' => 6
        ];

        $bookings = [
            [
                'id' => 1,
                'creator' => 'Maria Rodriguez',
                'creatorImage' => asset('images/default-avatar.svg'),
                'service' => 'Portretfotografie',
                'date' => '2024-09-28',
                'time' => '14:00',
                'status' => 'confirmed',
                'amount' => 150,
                'location' => 'Willemstad'
            ],
            [
                'id' => 2,
                'creator' => 'Carlos Martina',
                'creatorImage' => asset('images/default-avatar.svg'),
                'service' => 'Evenement Fotografie',
                'date' => '2024-10-05',
                'time' => '18:00',
                'status' => 'pending',
                'amount' => 300,
                'location' => 'Punda'
            ],
            [
                'id' => 3,
                'creator' => 'Isabella Santos',
                'creatorImage' => asset('images/default-avatar.svg'),
                'service' => 'Logo Design',
                'date' => '2024-09-15',
                'time' => '10:00',
                'status' => 'completed',
                'amount' => 200,
                'location' => 'Online'
            ]
        ];

        $favoriteCreators = [
            [
                'id' => 1,
                'name' => 'Maria Rodriguez',
                'profession' => 'Fotograaf',
                'image' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=300&h=200&fit=crop',
                'profileImage' => asset('images/default-avatar.svg'),
                'rating' => 4.9,
                'reviews' => 127,
                'location' => 'Willemstad',
                'startingPrice' => 75
            ],
            [
                'id' => 2,
                'name' => 'Carlos Martina',
                'profession' => 'Muzikant',
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&h=200&fit=crop',
                'profileImage' => asset('images/default-avatar.svg'),
                'rating' => 4.8,
                'reviews' => 89,
                'location' => 'Punda',
                'startingPrice' => 100
            ],
            [
                'id' => 3,
                'name' => 'Isabella Santos',
                'profession' => 'Designer',
                'image' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=300&h=200&fit=crop',
                'profileImage' => asset('images/default-avatar.svg'),
                'rating' => 4.7,
                'reviews' => 65,
                'location' => 'Otrobanda',
                'startingPrice' => 50
            ]
        ];

        $reviews = [
            [
                'id' => 1,
                'creator' => 'Maria Rodriguez',
                'service' => 'Portretfotografie',
                'rating' => 5,
                'comment' => 'Geweldige ervaring! Maria was zeer professioneel en de foto\'s zijn prachtig geworden.',
                'date' => '2024-09-10',
                'helpful' => 12
            ],
            [
                'id' => 2,
                'creator' => 'Carlos Martina',
                'service' => 'Live Muziek',
                'rating' => 5,
                'comment' => 'Carlos maakte ons evenement onvergetelijk met zijn muziek. Zeer aan te bevelen!',
                'date' => '2024-08-22',
                'helpful' => 8
            ]
        ];

        return view('member.dashboard', compact('userStats', 'bookings', 'favoriteCreators', 'reviews'));
    }

    /**
     * Get authenticated user's profile data
     */
    public function getProfile()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Get or create member profile
            $memberProfile = MemberProfile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'first_name' => '',
                    'last_name' => '',
                    'bio' => '',
                    'location' => '',
                    'interests' => '',
                ]
            );

            // Split user name if profile names are empty
            $nameParts = explode(' ', $user->name, 2);
            $firstName = $memberProfile->first_name ?: ($nameParts[0] ?? '');
            $lastName = $memberProfile->last_name ?: ($nameParts[1] ?? '');

            $profileData = [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $user->email,
                'bio' => $memberProfile->bio ?? '',
                'location' => $memberProfile->location ?? '',
                'interests' => $memberProfile->interests ?? '',
                'avatar' => $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.svg')
            ];

            return response()->json([
                'success' => true,
                'data' => $profileData
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching member profile: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error fetching profile data'
            ], 500);
        }
    }

    /**
     * Update authenticated user's profile data
     */
    public function updateProfile(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Validate the request
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($user->id),
                ],
                'bio' => 'nullable|string|max:1000',
                'location' => 'nullable|string|max:255',
                'interests' => 'nullable|string|max:500',
            ]);

            // Update user basic information
            $userData = [
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
            ];

            $user->update($userData);

            // Update or create member profile
            MemberProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'first_name' => $validated['first_name'],
                    'last_name' => $validated['last_name'],
                    'bio' => $validated['bio'],
                    'location' => $validated['location'],
                    'interests' => $validated['interests'],
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error updating member profile: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error updating profile'
            ], 500);
        }
    }

    /**
     * Get authenticated user's favorite creators
     */
    public function getFavorites()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Get user's favorites with creator profile and user data
            $favorites = Favorite::where('user_id', $user->id)
                ->with([
                    'creatorProfile' => function ($query) {
                        $query->where('is_active', true);
                    },
                    'creatorProfile.user',
                    'creatorProfile.talentCategories'
                ])
                ->get()
                ->filter(function ($favorite) {
                    return $favorite->creatorProfile && $favorite->creatorProfile->user;
                })
                ->map(function ($favorite) {
                    $creator = $favorite->creatorProfile;
                    $user = $creator->user;

                    // Get primary talent category
                    $primaryCategory = $creator->talentCategories->first();
                    //     $profileImage = $creator->avatar
                    // ? asset('storage/' . $creator->avatar)
                    // : asset('images/default-avatar.svg');
                    return [
                        'id' => $creator->user_id,
                        'name' => $user->name,
                        'profession' => $primaryCategory ? $primaryCategory->name : 'Creator',
                        // 'image' => $creator->banner_image ? asset('storage/' . $creator->banner_image) : 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=300&h=200&fit=crop',
                        'image' => $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.svg'),
                        'profileImage' => $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.svg'),
                        'rating' => 4.8, // This could be calculated from reviews if implemented
                        'reviews' => 0, // This could be calculated from reviews if implemented
                        'location' => 'Curaçao', // This could come from user profile or creator profile
                        'startingPrice' => 75, // This could come from services if implemented
                        'short_bio' => $creator->short_bio ?? '',
                        'profile_views' => $creator->profile_views ?? 0,
                        'total_likes' => $creator->getLikesCount(),
                        'is_featured' => $creator->is_featured ?? false
                    ];
                })
                ->values();

            return response()->json([
                'success' => true,
                'data' => $favorites
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching user favorites: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error fetching favorites data'
            ], 500);
        }
    }

    /**
     * Get authenticated user's favorites count
     */
    public function getFavoritesCount()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Get count of user's favorites with active creator profiles
            $count = Favorite::where('user_id', $user->id)
                ->whereHas('creatorProfile', function ($query) {
                    $query->where('is_active', true);
                })
                ->count();

            return response()->json([
                'success' => true,
                'count' => $count
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching user favorites count: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error fetching favorites count'
            ], 500);
        }
    }

    /**
     * Remove a creator from user's favorites
     */
    public function removeFavorite(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $validated = $request->validate([
                'creator_profile_id' => 'required|integer|exists:creator_profiles,id'
            ]);

            $favorite = Favorite::where('user_id', $user->id)
                ->where('creator_profile_id', $validated['creator_profile_id'])
                ->first();

            if (!$favorite) {
                return response()->json([
                    'success' => false,
                    'message' => 'Favorite not found'
                ], 404);
            }

            $favorite->delete();

            return response()->json([
                'success' => true,
                'message' => 'Creator removed from favorites'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error removing favorite: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error removing favorite'
            ], 500);
        }
    }

    public function getConversations()
    {
        try {
            $conversations = Conversation::where('member_id', Auth::id())
                ->with(['creator' => function ($query) {
                    $query->select('id', 'name');
                }])
                ->orderBy('last_message_at', 'desc')
                ->get()
                ->map(function ($conversation) {
                    return [
                        'id' => $conversation->id,
                        'creator_name' => $conversation->creator->name ?? 'Unknown Creator',
                        'last_message_at' => $conversation->last_message_at ? $conversation->last_message_at->diffForHumans() : 'No messages yet',
                        'creator_id' => $conversation->creator_id
                    ];
                });

            return response()->json([
                'success' => true,
                'conversations' => $conversations
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching conversations: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error fetching conversations'
            ], 500);
        }
    }
}
