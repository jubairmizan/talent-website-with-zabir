<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreatorProfile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'youtube_profile_url',
        'short_bio',
        'about_me',
        'banner_image',
        'resume_cv',
        'website_url',
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'linkedin_url',
        'youtube_url',
        'tiktok_url',
        'is_featured',
        'profile_views',
        'total_likes',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'profile_views' => 'integer',
        'total_likes' => 'integer',
    ];

    /**
     * Get the user that owns the creator profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the talent categories for this creator.
     */
    public function talentCategories()
    {
        return $this->belongsToMany(TalentCategory::class, 'creator_talent_categories');
    }

    /**
     * Get the portfolio items for this creator.
     */
    public function portfolioItems()
    {
        return $this->hasMany(PortfolioItem::class);
    }

    /**
     * Get the likes for this creator.
     */
    public function likes()
    {
        return $this->hasMany(CreatorLike::class);
    }

    /**
     * Get the users who favorited this creator.
     */
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    /**
     * Increment the profile views count.
     */
    public function incrementViews()
    {
        $this->increment('profile_views');
    }

    /**
     * Update the total likes count.
     */
    public function updateLikesCount()
    {
        $this->total_likes = $this->likes()->count();
        $this->save();
    }

    /**
     * Get the likes count for this creator.
     */
    public function getLikesCount()
    {
        return $this->likes()->count();
    }
}
