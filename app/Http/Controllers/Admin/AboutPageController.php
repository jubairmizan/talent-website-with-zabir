<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutPageSettings;
use App\Models\AboutPageValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutPageController extends Controller
{
    /**
     * Display the about page settings form
     */
    public function index()
    {
        $settings = AboutPageSettings::firstOrCreate([]);
        $values = AboutPageValue::ordered()->get();

        return view('admin.website.about.index', compact('settings', 'values'));
    }

    /**
     * Update the about page settings
     */
    public function update(Request $request)
    {
        $settings = AboutPageSettings::firstOrCreate([]);

        // Build validation rules based on which fields are present
        $rules = [];

        // Hero & Mission tab fields
        if ($request->has('hero_title')) {
            $rules['hero_title'] = 'required|string|max:255';
            $rules['hero_subtitle'] = 'required|string';
            $rules['hero_button_text'] = 'required|string|max:255';
            $rules['mission_title'] = 'required|string|max:255';
            $rules['mission_description_1'] = 'required|string';
            $rules['mission_description_2'] = 'required|string';
            $rules['mission_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240';
            $rules['mission_image_url'] = 'nullable|url';
        }

        // Statistics tab fields
        if ($request->has('stat_talents_count')) {
            $rules['stat_talents_count'] = 'required|string|max:50';
            $rules['stat_talents_label'] = 'required|string|max:255';
            $rules['stat_projects_count'] = 'required|string|max:50';
            $rules['stat_projects_label'] = 'required|string|max:255';
            $rules['values_section_title'] = 'required|string|max:255';
            $rules['values_section_subtitle'] = 'required|string';
        }

        $validated = $request->validate($rules);

        // Handle mission image upload
        if ($request->hasFile('mission_image')) {
            // Delete old image if exists
            if ($settings->mission_image_url && !filter_var($settings->mission_image_url, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($settings->mission_image_url);
            }

            $path = $request->file('mission_image')->store('about/mission', 'public');
            $validated['mission_image_url'] = $path;
        } elseif ($request->filled('mission_image_url')) {
            $validated['mission_image_url'] = $request->mission_image_url;
        }

        $settings->update($validated);

        return redirect()->back()->with('success', 'About page settings updated successfully!');
    }

    /**
     * Store a new value
     */
    public function storeValue(Request $request)
    {
        $validated = $request->validate([
            'icon' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Get the next order number
        $maxOrder = AboutPageValue::max('order') ?? 0;
        $validated['order'] = $maxOrder + 1;

        AboutPageValue::create($validated);

        return redirect()->back()->with('success', 'Value added successfully!');
    }

    /**
     * Update a value
     */
    public function updateValue(Request $request, AboutPageValue $value)
    {
        $validated = $request->validate([
            'icon' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $value->update($validated);

        return redirect()->back()->with('success', 'Value updated successfully!');
    }

    /**
     * Delete a value
     */
    public function deleteValue(AboutPageValue $value)
    {
        $value->delete();

        return redirect()->back()->with('success', 'Value deleted successfully!');
    }

    /**
     * Reorder values
     */
    public function reorderValues(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|integer|exists:about_page_values,id',
        ]);

        foreach ($request->order as $index => $id) {
            AboutPageValue::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true, 'message' => 'Values reordered successfully!']);
    }
}
