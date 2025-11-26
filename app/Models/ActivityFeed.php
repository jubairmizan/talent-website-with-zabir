<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityFeed extends Model
{
    use HasFactory;
    
    protected $table = 'activity_feed';

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'description',
        'data',
        'talent_category_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'data' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function talentCategory()
    {
        return $this->belongsTo(TalentCategory::class);
    }
}