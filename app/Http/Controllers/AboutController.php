<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutPageSettings;
use App\Models\AboutPageValue;

class AboutController extends Controller
{
    public function index()
    {
        // Get settings from database
        $settings = AboutPageSettings::firstOrCreate([]);

        // Get active values ordered
        $values = AboutPageValue::active()->ordered()->get();

        return view('about', compact('settings', 'values'));
    }
}
