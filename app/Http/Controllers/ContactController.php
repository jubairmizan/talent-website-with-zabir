<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactSubmission;
use App\Models\ContactPageSettings;
use App\Models\ContactPageFaq;

class ContactController extends Controller
{
    public function index()
    {
        // Get settings from database
        $settings = ContactPageSettings::firstOrCreate([]);

        // Get active FAQs ordered
        $faqs = ContactPageFaq::active()->ordered()->get();

        return view('contact', compact('settings', 'faqs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'category' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Store the contact submission
        ContactSubmission::create($validated);

        // Redirect back with success message
        return redirect()->back()->with('success', true);
    }
}
