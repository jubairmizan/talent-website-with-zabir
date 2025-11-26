<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreatorLike extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $fillable = [
        'creator_profile_id',
        'user_id',
    ];
    
    public function creatorProfile()
    {
        return $this->belongsTo(CreatorProfile::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
