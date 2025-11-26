<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutPageSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'hero_button_text',
        'mission_title',
        'mission_description_1',
        'mission_description_2',
        'mission_image_url',
        'stat_talents_count',
        'stat_talents_label',
        'stat_projects_count',
        'stat_projects_label',
        'values_section_title',
        'values_section_subtitle',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the mission image URL
     */
    public function getMissionImageUrlAttribute($value)
    {
        if (!$value) {
            return 'https://images.unsplash.com/photo-1559136555-9303baea8ebd?w=600&h=400&fit=crop';
        }

        // If it's already a full URL, return as is
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        // Otherwise, return the storage URL
        return asset('storage/' . $value);
    }
}
