<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CreatorProfile;
use App\Models\HomepageSettings;
use App\Models\HomepageSlide;

class HomeController extends Controller
{
    /**
     * Show the landing page.
     */
    public function index()
    {
        // Get homepage settings
        $settings = HomepageSettings::where('is_active', true)->first();

        // Create default settings if none exist
        if (!$settings) {
            $settings = HomepageSettings::create([
                'hero_title' => 'ONTDEK CREATORS OP CURAÇAO',
                'hero_subtitle' => 'Jouw brug naar lokaal talent',
                'hero_video_url' => 'https://brugkreativo.com/images/home-video.mp4',
                'search_placeholder_text' => 'Zoek hier naar creators...',
                'is_active' => true,
            ]);
        }

        // Get background slides
        $slides = HomepageSlide::where('is_active', true)
            ->orderBy('order')
            ->get();

        // Get featured creators with their user details and talent categories
        $featuredCreators = CreatorProfile::with(['user', 'talentCategories'])
            ->where('is_featured', true)
            ->where('is_active', true)
            ->whereHas('user', function ($query) {
                $query->where('status', 'active');
            })
            ->orderBy('profile_views', 'desc')
            ->take(8)
            ->get();

        // If not enough featured creators, fill with popular creators
        if ($featuredCreators->count() < 8) {
            $additionalCreators = CreatorProfile::with(['user', 'talentCategories'])
                ->where('is_active', true)
                ->whereHas('user', function ($query) {
                    $query->where('status', 'active');
                })
                ->whereNotIn('id', $featuredCreators->pluck('id'))
                ->orderBy('profile_views', 'desc')
                ->take(8 - $featuredCreators->count())
                ->get();

            $featuredCreators = $featuredCreators->merge($additionalCreators);
        }

        return view('home', compact('settings', 'slides', 'featuredCreators'));
    }
}
