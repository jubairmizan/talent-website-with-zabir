<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'avatar',
        'featured_video',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    // Role constants
    const ROLE_CREATOR = 'creator';
    const ROLE_MEMBER = 'member';
    const ROLE_ADMIN = 'admin';

    // Status constants
    const STATUS_ACTIVE = 'active';
    const STATUS_BANNED = 'banned';
    const STATUS_PENDING = 'pending';

    /**
     * Check if user has a specific role
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->hasRole(self::ROLE_ADMIN);
    }

    /**
     * Check if user is a creator
     */
    public function isCreator(): bool
    {
        return $this->hasRole(self::ROLE_CREATOR);
    }

    /**
     * Check if user is a member
     */
    public function isMember(): bool
    {
        return $this->hasRole(self::ROLE_MEMBER);
    }

    /**
     * Check if user is active
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Get the creator profile associated with the user.
     */
    public function creatorProfile()
    {
        return $this->hasOne(CreatorProfile::class);
    }

    /**
     * Get the member profile associated with the user.
     */
    public function memberProfile()
    {
        return $this->hasOne(MemberProfile::class);
    }

    /**
     * Get the favorites for the user.
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Get the creator profiles that this user has favorited.
     */
    public function favoriteCreators()
    {
        return $this->belongsToMany(CreatorProfile::class, 'favorites', 'user_id', 'creator_profile_id')
            ->withTimestamps();
    }

    /**
     * Check if user has favorited a specific creator profile.
     */
    public function hasFavorited($creatorProfileId)
    {
        return $this->favorites()->where('creator_profile_id', $creatorProfileId)->exists();
    }

    /**
     * Get conversations where user is a member
     */
    public function conversationsAsMember()
    {
        return $this->hasMany(Conversation::class, 'member_id');
    }

    /**
     * Get conversations where user is a creator
     */
    public function conversationsAsCreator()
    {
        return $this->hasMany(Conversation::class, 'creator_id');
    }

    /**
     * Get all conversations for this user (as either member or creator)
     */
    public function conversations()
    {
        // This will return conversations where the user is either creator or member
        // Note: This is a query scope approach, not a direct relationship
        return Conversation::where('creator_id', $this->id)
            ->orWhere('member_id', $this->id);
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];
}
