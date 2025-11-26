<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\CreatorProfile;
use App\Models\MemberProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        $validation = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'role' => ['required', 'string', 'in:talent,client'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ];

        // Additional validation for creators/talents
        if (isset($input['role']) && $input['role'] === 'talent') {
            $validation = array_merge($validation, [
                'short_bio' => ['required', 'string', 'max:500'],
                'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                'banner_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
                'website_url' => ['nullable', 'url', 'max:500'],
                'facebook_url' => ['nullable', 'url', 'max:500'],
                'instagram_url' => ['nullable', 'string', 'max:500'], // Allow @username format
                'twitter_url' => ['nullable', 'url', 'max:500'],
                'linkedin_url' => ['nullable', 'url', 'max:500'],
                'youtube_url' => ['nullable', 'url', 'max:500'],
                'tiktok_url' => ['nullable', 'url', 'max:500'],
            ]);
        }

        // Additional validation for clients/members
        if (isset($input['role']) && $input['role'] === 'client') {
            $validation = array_merge($validation, [
                'first_name' => ['required', 'string', 'max:100'],
                'last_name' => ['required', 'string', 'max:100'],
                'location' => ['nullable', 'string', 'max:255'],
                'member_bio' => ['nullable', 'string', 'max:1000'],
                'interests' => ['nullable', 'string', 'max:500'],
            ]);
        }

        Validator::make($input, $validation)->validate();

        return DB::transaction(function () use ($input) {
            // Map frontend role values to database values
            $roleMapping = [
                'talent' => 'creator',
                'client' => 'member'
            ];

            // Handle avatar upload
            $avatarPath = null;
            if (isset($input['avatar']) && $input['avatar'] instanceof \Illuminate\Http\UploadedFile) {
                $avatarPath = $input['avatar']->store('avatars', 'public');
            }

            // Handle banner image upload
            $bannerPath = null;
            if (isset($input['banner_image']) && $input['banner_image'] instanceof \Illuminate\Http\UploadedFile) {
                $bannerPath = $input['banner_image']->store('banners', 'public');
            }

            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'role' => $roleMapping[$input['role']] ?? 'member',
                'status' => 'active', // Users start as active for immediate access
                'avatar' => $avatarPath,
            ]);

            // Create creator profile if role is talent
            if ($input['role'] === 'talent') {
                CreatorProfile::create([
                    'user_id' => $user->id,
                    'short_bio' => $input['short_bio'],
                    'banner_image' => $bannerPath,
                    'website_url' => $input['website_url'] ?? null,
                    'facebook_url' => $input['facebook_url'] ?? null,
                    'instagram_url' => $input['instagram_url'] ?? null,
                    'twitter_url' => $input['twitter_url'] ?? null,
                    'linkedin_url' => $input['linkedin_url'] ?? null,
                    'youtube_url' => $input['youtube_url'] ?? null,
                    'tiktok_url' => $input['tiktok_url'] ?? null,
                    'is_active' => true,
                    'is_featured' => false,
                    'profile_views' => 0,
                    'total_likes' => 0,
                ]);
            }

            // Create member profile if role is client
            if ($input['role'] === 'client') {
                MemberProfile::create([
                    'user_id' => $user->id,
                    'first_name' => $input['first_name'],
                    'last_name' => $input['last_name'],
                    'bio' => $input['member_bio'] ?? null,
                    'location' => $input['location'] ?? null,
                    'interests' => $input['interests'] ?? null,
                ]);
            }

            return $user;
        });
    }
}
