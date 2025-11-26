<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactPageSettings;
use App\Models\ContactPageFaq;
use Illuminate\Http\Request;

class ContactPageController extends Controller
{
    /**
     * Display the contact page settings form
     */
    public function index()
    {
        $settings = ContactPageSettings::firstOrCreate([]);
        $faqs = ContactPageFaq::ordered()->get();

        return view('admin.website.contact.index', compact('settings', 'faqs'));
    }

    /**
     * Update the contact page settings
     */
    public function update(Request $request)
    {
        $settings = ContactPageSettings::firstOrCreate([]);

        // Build validation rules based on which fields are present
        $rules = [];

        // Hero & Form tab fields
        if ($request->has('hero_title')) {
            $rules['hero_title'] = 'required|string|max:255';
            $rules['hero_subtitle'] = 'required|string';
            $rules['form_section_title'] = 'required|string|max:255';
            $rules['form_section_subtitle'] = 'required|string';
            $rules['form_button_text'] = 'required|string|max:255';
            $rules['success_title'] = 'required|string|max:255';
            $rules['success_message'] = 'required|string';
            $rules['success_button_text'] = 'required|string|max:255';
        }

        // Contact Info tab fields
        if ($request->has('contact_info_title')) {
            $rules['contact_info_title'] = 'required|string|max:255';
            $rules['contact_address'] = 'nullable|string|max:255';
            $rules['contact_email'] = 'nullable|email|max:255';
            $rules['contact_phone'] = 'nullable|string|max:50';
            $rules['contact_hours'] = 'nullable|string';
            $rules['faq_section_title'] = 'required|string|max:255';
        }

        $validated = $request->validate($rules);
        $settings->update($validated);

        return redirect()->back()->with('success', 'Contact page settings updated successfully!');
    }

    /**
     * Store a new FAQ
     */
    public function storeFaq(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        // Get the next order number
        $maxOrder = ContactPageFaq::max('order') ?? 0;
        $validated['order'] = $maxOrder + 1;

        ContactPageFaq::create($validated);

        return redirect()->back()->with('success', 'FAQ added successfully!');
    }

    /**
     * Update a FAQ
     */
    public function updateFaq(Request $request, ContactPageFaq $faq)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $faq->update($validated);

        return redirect()->back()->with('success', 'FAQ updated successfully!');
    }

    /**
     * Delete a FAQ
     */
    public function deleteFaq(ContactPageFaq $faq)
    {
        $faq->delete();

        return redirect()->back()->with('success', 'FAQ deleted successfully!');
    }

    /**
     * Reorder FAQs
     */
    public function reorderFaqs(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|integer|exists:contact_page_faqs,id',
        ]);

        foreach ($request->order as $index => $id) {
            ContactPageFaq::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true, 'message' => 'FAQs reordered successfully!']);
    }
}
