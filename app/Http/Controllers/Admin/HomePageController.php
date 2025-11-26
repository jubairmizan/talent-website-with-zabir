<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageSettings;
use App\Models\HomepageSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HomePageController extends Controller
{
    /**
     * Show the home page settings form.
     */
    public function index()
    {
        $settings = HomepageSettings::first();

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

        return view('admin.website.home.index', compact('settings'));
    }

    /**
     * Update the home page settings.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string|max:255',
            'hero_video_url' => 'nullable|url|max:500',
            'search_placeholder_text' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $settings = HomepageSettings::first();

        if (!$settings) {
            $settings = new HomepageSettings();
        }

        $settings->fill($request->only([
            'hero_title',
            'hero_subtitle',
            'hero_video_url',
            'search_placeholder_text',
        ]));
        $settings->save();

        return redirect()->route('admin.website.home.index')
            ->with('success', 'Homepage settings updated successfully!');
    }

    /**
     * Show the background slides management page.
     */
    public function slides()
    {
        $slides = HomepageSlide::orderBy('order')->get();
        return view('admin.website.home.slides', compact('slides'));
    }

    /**
     * Store a new slide.
     */
    public function storeSlide(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB max
            'image_url' => 'nullable|url|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check that at least one of image or image_url is provided
        if (!$request->hasFile('image') && !$request->filled('image_url')) {
            return redirect()->back()
                ->with('error', 'Please provide either an image file or image URL.')
                ->withInput();
        }

        $imagePath = null;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('homepage/slides', 'public');
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->input('image_url');
        }

        if (!$imagePath) {
            return redirect()->back()
                ->with('error', 'Please provide either an image file or image URL.');
        }

        // Get the highest order number and add 1
        $maxOrder = HomepageSlide::max('order') ?? 0;

        HomepageSlide::create([
            'image_path' => $imagePath,
            'order' => $maxOrder + 1,
            'is_active' => true,
        ]);

        return redirect()->route('admin.website.home.slides')
            ->with('success', 'Slide added successfully!');
    }

    /**
     * Delete a slide.
     */
    public function destroySlide(HomepageSlide $slide)
    {
        // Delete the image file if it's stored locally
        if (!filter_var($slide->image_path, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($slide->image_path);
        }

        $slide->delete();

        return redirect()->route('admin.website.home.slides')
            ->with('success', 'Slide deleted successfully!');
    }

    /**
     * Reorder slides.
     */
    public function reorderSlides(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slides' => 'required|array',
            'slides.*.id' => 'required|exists:homepage_slides,id',
            'slides.*.order' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid data provided.',
            ], 422);
        }

        foreach ($request->slides as $slideData) {
            HomepageSlide::where('id', $slideData['id'])
                ->update(['order' => $slideData['order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Slides reordered successfully!',
        ]);
    }

    /**
     * Toggle slide active status.
     */
    public function toggleSlide(HomepageSlide $slide)
    {
        $slide->is_active = !$slide->is_active;
        $slide->save();

        return redirect()->route('admin.website.home.slides')
            ->with('success', 'Slide status updated successfully!');
    }
}
