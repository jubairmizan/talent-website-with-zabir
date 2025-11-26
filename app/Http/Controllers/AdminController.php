<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\CreatorProfile;
use App\Models\MemberProfile;
use App\Models\BlogPost;
use App\Models\ContactSubmission;
use App\Models\PortfolioItem;

class AdminController extends Controller
{
    // Admin authentication is now handled by Laravel Fortify
    // All users use the standard /login route

    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        // Get dashboard statistics
        $stats = [
            'total_users' => User::count(),
            'total_creators' => CreatorProfile::count(),
            'total_members' => MemberProfile::count(),
            'total_blog_posts' => BlogPost::count(),
            'total_portfolio_items' => PortfolioItem::count(),
            'pending_contacts' => ContactSubmission::where('status', 'unread')->count(),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_contacts' => ContactSubmission::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Show users management
     */
    public function users(Request $request)
    {
        $query = User::with(['creatorProfile', 'memberProfile']);

        // Apply role filter
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Apply search filter
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->paginate(10)->appends($request->query());

        // Calculate user statistics
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'pending_users' => User::where('status', 'pending')->count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'creator_users' => User::where('role', 'creator')->count(),
            'member_users' => User::where('role', 'member')->count(),
            'banned_users' => User::where('status', 'banned')->count(),
        ];

        // Get current filters for the view
        $filters = [
            'role' => $request->get('role'),
            'status' => $request->get('status'),
            'search' => $request->get('search'),
        ];

        return view('admin.users.index', compact('users', 'stats', 'filters'));
    }

    /**
     * Show creators management
     */
    public function creators()
    {
        $creators = CreatorProfile::with(['user', 'portfolioItems'])
            ->paginate(20);

        return view('admin.creators.index', compact('creators'));
    }

    /**
     * Show contact submissions
     */
    public function contacts()
    {
        $contacts = ContactSubmission::latest()->paginate(20);

        // Get contact statistics
        $stats = [
            'total_messages' => ContactSubmission::count(),
            'unread_messages' => ContactSubmission::where('status', 'unread')->count(),
            'replied_messages' => ContactSubmission::where('status', 'replied')->count(),
            'high_priority' => ContactSubmission::where('status', 'unread')->count(), // For now, consider unread as high priority
        ];

        return view('admin.contacts', compact('contacts', 'stats'));
    }

    /**
     * Update contact submission status
     */
    public function updateContactStatus(Request $request, ContactSubmission $contact)
    {
        $request->validate([
            'status' => 'required|in:unread,read,replied',
        ]);

        $contact->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Contact status updated successfully.');
    }

    /**
     * Toggle user status (active/inactive)
     */
    public function toggleUserStatus(User $user)
    {
        $newStatus = $user->status === 'active' ? 'inactive' : 'active';

        $user->update([
            'status' => $newStatus,
        ]);

        $statusText = $newStatus === 'active' ? 'activated' : 'deactivated';

        return back()->with('success', "User has been {$statusText} successfully.");
    }

    /**
     * Create a new user
     */
    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,creator,member',
            'status' => 'required|in:active,banned,pending',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            // 'featured_video' => 'nullable|mimes:mp4,mov,avi,wmv|max:20480',
            'featured_video' => [
                'nullable',
                'file',
                'mimetypes:video/mp4,video/mpeg,video/quicktime,video/x-msvideo',
                'max:20480' // 20MB in kilobytes
            ],
        ]);
        // Handle avatar upload
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        // Handle banner image upload
        $bannerPath = null;
        if ($request->hasFile('banner_image')) {
            $bannerPath = $request->file('banner_image')->store('banners', 'public');
        }

        // Handle featured video upload
        // $featuredVideoPath = null;
        // if ($request->hasFile('featured_video')) {
        //     $featuredVideoPath = $request->file('featured_video')->store('videos/featured', 'public');
        // }

        // Handle featured video upload with better error handling
        $featuredVideoPath = null;
        if ($request->hasFile('featured_video')) {
            $file = $request->file('featured_video');

            // Check if file is valid
            if ($file->isValid()) {
                $featuredVideoPath = $file->store('videos/featured', 'public');
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Featured video upload failed: Invalid file.',
                ], 422);
            }
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
            'avatar' => $avatarPath,
            'featured_video' => $featuredVideoPath,
        ]);

        // Handle creator profile if role is creator
        if ($request->role === 'creator' && $request->has('creator_profile')) {
            $profileData = $request->creator_profile;

            $user->creatorProfile()->create([
                'youtube_profile_url' => $profileData['youtube_profile_url'] ?? null,
                'short_bio' => $profileData['short_bio'] ?? null,
                'about_me' => $profileData['about_me'] ?? null,
                'website_url' => $profileData['website_url'] ?? null,
                'banner_image' => $bannerPath,
                'resume_cv' => $profileData['resume_cv'] ?? null,
                'facebook_url' => $profileData['facebook_url'] ?? null,
                'instagram_url' => $profileData['instagram_url'] ?? null,
                'twitter_url' => $profileData['twitter_url'] ?? null,
                'linkedin_url' => $profileData['linkedin_url'] ?? null,
                'youtube_url' => $profileData['youtube_url'] ?? null,
                'tiktok_url' => $profileData['tiktok_url'] ?? null,
                'is_active' => $profileData['is_active'] ?? true,
                'is_featured' => $profileData['is_featured'] ?? false,
                'profile_views' => $profileData['profile_views'] ?? 0,
                'total_likes' => $profileData['total_likes'] ?? 0,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'User created successfully.',
            'user' => $user->fresh(['creatorProfile'])
        ]);
    }

    /**
     * Get user data for editing
     */
    public function editUser(User $user)
    {
        $user->load(['creatorProfile', 'memberProfile']);

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    /**
     * Update user details with profile data
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,creator,member',
            'status' => 'required|in:active,banned,pending',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'featured_video' => 'nullable|mimes:mp4,mov,avi,wmv|max:20480',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && \Storage::disk('public')->exists($user->avatar)) {
                \Storage::disk('public')->delete($user->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        // Handle banner image upload
        $bannerPath = null;
        if ($request->hasFile('banner_image')) {
            // Delete old banner if exists
            if ($user->creatorProfile && $user->creatorProfile->banner_image && \Storage::disk('public')->exists($user->creatorProfile->banner_image)) {
                \Storage::disk('public')->delete($user->creatorProfile->banner_image);
            }
            $bannerPath = $request->file('banner_image')->store('banners', 'public');
        }

        // Handle featured video upload
        if ($request->hasFile('featured_video')) {
            // Delete old featured video if exists
            if ($user->featured_video && \Storage::disk('public')->exists($user->featured_video)) {
                \Storage::disk('public')->delete($user->featured_video);
            }
            $featuredVideoPath = $request->file('featured_video')->store('videos/featured', 'public');
            $user->featured_video = $featuredVideoPath;
        }

        // Update user basic info
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
        ]);

        // Handle creator profile if role is creator
        if ($request->role === 'creator' && $request->has('creator_profile')) {
            $profileData = $request->creator_profile;

            // Create or update creator profile
            $user->creatorProfile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'youtube_profile_url' => $profileData['youtube_profile_url'] ?? null,
                    'short_bio' => $profileData['short_bio'] ?? null,
                    'about_me' => $profileData['about_me'] ?? null,
                    'website_url' => $profileData['website_url'] ?? null,
                    'banner_image' => $bannerPath ?? ($user->creatorProfile ? $user->creatorProfile->banner_image : null),
                    'resume_cv' => $profileData['resume_cv'] ?? null,
                    'facebook_url' => $profileData['facebook_url'] ?? null,
                    'instagram_url' => $profileData['instagram_url'] ?? null,
                    'twitter_url' => $profileData['twitter_url'] ?? null,
                    'linkedin_url' => $profileData['linkedin_url'] ?? null,
                    'youtube_url' => $profileData['youtube_url'] ?? null,
                    'tiktok_url' => $profileData['tiktok_url'] ?? null,
                    'is_active' => $profileData['is_active'] ?? true,
                    'is_featured' => $profileData['is_featured'] ?? false,
                    'profile_views' => $profileData['profile_views'] ?? 0,
                    'total_likes' => $profileData['total_likes'] ?? 0,
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully.',
            'user' => $user->fresh(['creatorProfile'])
        ]);
    }

    /**
     * Quick status change for users
     */
    public function updateUserStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|in:active,banned,pending',
        ]);

        $user->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User status updated successfully.',
            'user' => $user->fresh()
        ]);
    }

    /**
     * Reset user password
     */
    public function resetUserPassword(User $user)
    {
        // Generate a new random password
        $newPassword = \Str::random(12);

        // Update user password
        $user->update([
            'password' => Hash::make($newPassword)
        ]);

        // In a real application, you would send this via email
        // For now, we'll just return it in the response for demo purposes
        // TODO: Send password reset email

        return response()->json([
            'success' => true,
            'message' => 'Password has been reset successfully. New password: ' . $newPassword,
            'new_password' => $newPassword // Remove this in production - send via email instead
        ]);
    }

    /**
     * Delete user
     */
    public function deleteUser(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete your own account.'
            ], 403);
        }

        // Delete related profiles
        if ($user->creatorProfile) {
            $user->creatorProfile->delete();
        }
        if ($user->memberProfile) {
            $user->memberProfile->delete();
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully.'
        ]);
    }

    // Admin logout is now handled by Laravel Fortify
    // Users can logout using the standard /logout route
}
