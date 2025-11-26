<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactPageSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'form_section_title',
        'form_section_subtitle',
        'form_button_text',
        'success_title',
        'success_message',
        'success_button_text',
        'contact_info_title',
        'contact_address',
        'contact_email',
        'contact_phone',
        'contact_hours',
        'faq_section_title',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
