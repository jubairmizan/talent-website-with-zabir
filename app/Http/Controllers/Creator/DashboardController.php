<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\CreatorProfile;
use App\Models\PortfolioItem;
use App\Models\TalentCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Sample data - replace with actual data from database
        // $stats = [
        //     'totalBookings' => 24,
        //     'totalEarnings' => 3250.00,
        //     'averageRating' => 4.8,
        //     'profileViews' => 156
        // ];
        $stats = [
            'totalViews' => 12543,
            'totalBookings' => 89,
            'totalEarnings' => 4250,
            'rating' => 4.8,
            'reviews' => 127,
            'followers' => 856
        ];

        $recentBookings = [
            [
                'id' => 1,
                'client' => 'Sarah Johnson',
                'service' => 'Wedding Photography',
                'date' => '2024-01-15',
                'amount' => 850.00,
                'status' => 'confirmed'
            ],
            [
                'id' => 2,
                'client' => 'Mike Chen',
                'service' => 'Portrait Session',
                'date' => '2024-01-18',
                'amount' => 200.00,
                'status' => 'pending'
            ],
            [
                'id' => 3,
                'client' => 'Emma Davis',
                'service' => 'Event Photography',
                'date' => '2024-01-20',
                'amount' => 650.00,
                'status' => 'completed'
            ]
        ];

        // Get dynamic portfolio data from the database
        $creatorProfile = $user->creatorProfile;
        $portfolioItems = collect();

        if ($creatorProfile) {
            $portfolioItems = $creatorProfile->portfolioItems()
                ->where('is_active', true)
                ->orderBy('sort_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->limit(6) // Limit to 6 items for dashboard display
                ->get();
        }

        // Transform portfolio items to match the expected format
        $portfolio = $portfolioItems->map(function ($item) {
            // Generate image URL based on file path
            $imageUrl = $item->thumbnail_path
                ? asset('storage/' . $item->thumbnail_path)
                : ($item->file_path ? asset('storage/' . $item->file_path) : null);

            // Fallback to placeholder if no image
            if (!$imageUrl || $item->file_type === 'video') {
                $imageUrl = $item->thumbnail_path
                    ? asset('storage/' . $item->thumbnail_path)
                    : 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=300&h=200&fit=crop';
            }

            return [
                'id' => $item->id,
                'title' => $item->title,
                'description' => $item->description,
                'image' => $imageUrl,
                'file_type' => $item->file_type,
                'views' => rand(50, 500), // TODO: Implement actual view tracking
                'likes' => rand(10, 100), // TODO: Implement actual like system
                'created_at' => $item->created_at,
                'sort_order' => $item->sort_order
            ];
        })->toArray();

        // Fallback to sample data if no portfolio items exist
        if (empty($portfolio)) {
            $portfolio = [
                [
                    'id' => null,
                    'title' => 'Summer Wedding Collection',
                    'description' => 'Beautiful wedding photography collection',
                    'image' => 'https://images.unsplash.com/photo-1519741497674-611481863552?w=300&h=200&fit=crop',
                    'file_type' => 'image',
                    'views' => 234,
                    'likes' => 45,
                    'created_at' => now(),
                    'sort_order' => 1
                ],
                [
                    'id' => null,
                    'title' => 'Corporate Headshots',
                    'description' => 'Professional corporate photography',
                    'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&h=200&fit=crop',
                    'file_type' => 'image',
                    'views' => 189,
                    'likes' => 32,
                    'created_at' => now(),
                    'sort_order' => 2
                ],
                [
                    'id' => null,
                    'title' => 'Nature Photography',
                    'description' => 'Stunning nature and landscape photography',
                    'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=300&h=200&fit=crop',
                    'file_type' => 'image',
                    'views' => 156,
                    'likes' => 28,
                    'created_at' => now(),
                    'sort_order' => 3
                ]
            ];
        }

        // Get real user profile data
        $nameParts = explode(' ', $user->name, 2);
        $creatorProfile = $user->creatorProfile;

        $profile = [
            'firstName' => $nameParts[0] ?? '',
            'lastName' => $nameParts[1] ?? '',
            'email' => $user->email,
            'avatar' => $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.svg'),
            'short_bio' => $creatorProfile->short_bio ?? '',
            'about_me' => $creatorProfile->about_me ?? '',
            'banner_image' => $creatorProfile->banner_image ? asset('storage/' . $creatorProfile->banner_image) : '',
            'resume_cv' => $creatorProfile->resume_cv ? asset('storage/' . $creatorProfile->resume_cv) : '',
            'website_url' => $creatorProfile->website_url ?? '',
            'facebook_url' => $creatorProfile->facebook_url ?? '',
            'instagram_url' => $creatorProfile->instagram_url ?? '',
            'twitter_url' => $creatorProfile->twitter_url ?? '',
            'linkedin_url' => $creatorProfile->linkedin_url ?? '',
            'youtube_url' => $creatorProfile->youtube_url ?? '',
            'tiktok_url' => $creatorProfile->tiktok_url ?? '',
            'is_featured' => $creatorProfile->is_featured ?? false,
            'is_active' => $creatorProfile->is_active ?? true
        ];

        $locations = [
            'willemstad' => 'Willemstad',
            'punda' => 'Punda',
            'otrobanda' => 'Otrobanda',
            'scharloo' => 'Scharloo'
        ];

        // $analytics = [
        //     'profileViews' => [120, 135, 145, 156, 167, 178, 156],
        //     'bookingRequests' => [5, 8, 6, 12, 9, 15, 11],
        //     'earnings' => [450, 680, 520, 890, 750, 1200, 980]
        // ];
        $analytics = [
            'monthlyViews' => [
                'January' => 1250,
                'February' => 1100,
                'March' => 1350,
                'April' => 1500,
                'May' => 1200,
                'June' => 1400
            ],
            'monthlyEarnings' => [
                'thisMonth' => 850,
                'lastMonth' => 720,
                'yearTotal' => 4250
            ]
        ];

        // $messages = [
        //     [
        //         'id' => 1,
        //         'sender' => 'Sarah Johnson',
        //         'subject' => 'Wedding Photography Inquiry',
        //         'preview' => 'Hi John, I\'m interested in your wedding photography services...',
        //         'time' => '2 hours ago',
        //         'unread' => true
        //     ],
        //     [
        //         'id' => 2,
        //         'sender' => 'Mike Chen',
        //         'subject' => 'Portrait Session Follow-up',
        //         'preview' => 'Thank you for the amazing portrait session yesterday...',
        //         'time' => '1 day ago',
        //         'unread' => false
        //     ]
        // ];
        $messages = [
            [
                'id' => 1,
                'client' => 'Klant 1',
                'message' => 'Hallo, ik ben geïnteresseerd in je fotografie diensten...',
                'time' => '2 uur geleden',
                'status' => 'Nieuw',
                'avatar' => 'https://api.dicebear.com/7.x/initials/svg?seed=User1'
            ],
            [
                'id' => 2,
                'client' => 'Klant 2',
                'message' => 'Hallo, ik ben geïnteresseerd in je fotografie diensten...',
                'time' => '2 uur geleden',
                'status' => 'Nieuw',
                'avatar' => 'https://api.dicebear.com/7.x/initials/svg?seed=User2'
            ],
            [
                'id' => 3,
                'client' => 'Klant 3',
                'message' => 'Hallo, ik ben geïnteresseerd in je fotografie diensten...',
                'time' => '2 uur geleden',
                'status' => 'Nieuw',
                'avatar' => 'https://api.dicebear.com/7.x/initials/svg?seed=User3'
            ]
        ];

        // Get all talent categories for the form
        $talentCategories = TalentCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get(['id', 'name', 'slug', 'icon']);

        // Get current user's selected talent categories
        $selectedTalentCategories = $creatorProfile ?
            $creatorProfile->talentCategories()->pluck('talent_categories.id')->toArray() : [];

        return view('creator.dashboard', compact('stats', 'recentBookings', 'portfolio', 'profile', 'locations', 'analytics', 'messages', 'talentCategories', 'selectedTalentCategories'));
    }

    public function updateProfile(Request $request)
    {
        Log::info('Profile update started', [
            'user_id' => Auth::id(),
            'has_avatar' => $request->hasFile('avatar'),
            'has_banner' => $request->hasFile('banner_image'),
            'has_resume' => $request->hasFile('resume_cv'),
            'files' => $request->allFiles()
        ]);

        $user = Auth::user();

        // Validate the request - only validate fields that exist in the schema
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'short_bio' => 'nullable|string|max:500',
            'about_me' => 'nullable|string|max:2000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'resume_cv' => 'nullable|file|mimes:pdf,doc,docx|max:1024',
            'website_url' => 'nullable|url|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'tiktok_url' => 'nullable|url|max:255',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'talent_categories' => 'nullable|array',
            'talent_categories.*' => 'exists:talent_categories,id'
        ]);

        try {
            // Update user basic information
            $userData = [
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
            ];

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                Log::info('Avatar file detected', ['file' => $request->file('avatar')->getClientOriginalName()]);

                // Delete old avatar if exists
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                    Log::info('Old avatar deleted', ['path' => $user->avatar]);
                }

                // Store new avatar
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $userData['avatar'] = $avatarPath;
                Log::info('New avatar stored', ['path' => $avatarPath]);
            }

            // Update user
            Log::info('Updating user data', ['user_id' => $user->id, 'userData' => $userData]);
            $updateResult = User::where('id', $user->id)->update($userData);
            Log::info('User update result', ['result' => $updateResult]);

            // Prepare creator profile data
            $profileData = [
                'short_bio' => $request->short_bio,
                'about_me' => $request->about_me,
                'website_url' => $request->website_url,
                'facebook_url' => $request->facebook_url,
                'instagram_url' => $request->instagram_url,
                'twitter_url' => $request->twitter_url,
                'linkedin_url' => $request->linkedin_url,
                'youtube_url' => $request->youtube_url,
                'tiktok_url' => $request->tiktok_url,
                'is_featured' => $request->has('is_featured') ? 1 : 0,
                'is_active' => $request->has('is_active') ? 1 : 0,
            ];

            // Get existing profile to handle file deletions
            $existingProfile = CreatorProfile::where('user_id', $user->id)->first();

            // Handle banner image upload
            if ($request->hasFile('banner_image')) {
                Log::info('Banner image file detected', ['file' => $request->file('banner_image')->getClientOriginalName()]);

                // Delete old banner image if exists
                if ($existingProfile && $existingProfile->banner_image && Storage::disk('public')->exists($existingProfile->banner_image)) {
                    Storage::disk('public')->delete($existingProfile->banner_image);
                    Log::info('Old banner image deleted', ['path' => $existingProfile->banner_image]);
                }

                $bannerPath = $request->file('banner_image')->store('banners', 'public');
                $profileData['banner_image'] = $bannerPath;
                Log::info('New banner image stored', ['path' => $bannerPath]);
            }

            // Handle resume CV upload
            if ($request->hasFile('resume_cv')) {
                Log::info('Resume CV file detected', ['file' => $request->file('resume_cv')->getClientOriginalName()]);

                // Delete old resume if exists
                if ($existingProfile && $existingProfile->resume_cv && Storage::disk('public')->exists($existingProfile->resume_cv)) {
                    Storage::disk('public')->delete($existingProfile->resume_cv);
                    Log::info('Old resume CV deleted', ['path' => $existingProfile->resume_cv]);
                }

                $resumePath = $request->file('resume_cv')->store('resumes', 'public');
                $profileData['resume_cv'] = $resumePath;
                Log::info('New resume CV stored', ['path' => $resumePath]);
            }

            // Use updateOrCreate for more efficient database operation
            $creatorProfile = CreatorProfile::updateOrCreate(
                ['user_id' => $user->id],
                $profileData
            );

            // Sync talent categories
            if ($request->has('talent_categories')) {
                $creatorProfile->talentCategories()->sync($request->talent_categories);
                Log::info('Talent categories synced', [
                    'user_id' => $user->id,
                    'categories' => $request->talent_categories
                ]);
            } else {
                // If no categories selected, remove all associations
                $creatorProfile->talentCategories()->detach();
                Log::info('All talent categories removed', ['user_id' => $user->id]);
            }

            return redirect()->back()->with('success', 'Profile successfully updated!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred while updating your profile. Please try again.')
                ->withInput();
        }
    }

    /**
     * Download user's avatar file
     */
    public function downloadAvatar()
    {
        $user = auth()->user();

        if (!$user->avatar) {
            return redirect()->back()->with('error', 'No avatar file found.');
        }

        $filePath = storage_path('app/public/' . $user->avatar);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'Avatar file not found on server.');
        }

        $fileName = 'avatar_' . $user->name . '_' . basename($user->avatar);

        return response()->download($filePath, $fileName);
    }

    /**
     * Download user's banner image file
     */
    public function downloadBanner()
    {
        $user = auth()->user();
        $profile = $user->creatorProfile;

        if (!$profile || !$profile->banner_image) {
            return redirect()->back()->with('error', 'No banner image found.');
        }

        $filePath = storage_path('app/public/' . $profile->banner_image);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'Banner image file not found on server.');
        }

        $fileName = 'banner_' . $user->name . '_' . basename($profile->banner_image);

        return response()->download($filePath, $fileName);
    }

    /**
     * Download user's resume/CV file
     */
    public function downloadResume()
    {
        $user = auth()->user();
        $profile = $user->creatorProfile;

        if (!$profile || !$profile->resume_cv) {
            return redirect()->back()->with('error', 'No resume/CV found.');
        }

        $filePath = storage_path('app/public/' . $profile->resume_cv);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'Resume/CV file not found on server.');
        }

        $fileName = 'resume_' . $user->name . '_' . basename($profile->resume_cv);

        return response()->download($filePath, $fileName);
    }
}
