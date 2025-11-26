<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreatorTalentCategory extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $fillable = [
        'creator_profile_id',
        'talent_category_id',
    ];
    
    public function creatorProfile()
    {
        return $this->belongsTo(CreatorProfile::class);
    }
    
    public function talentCategory()
    {
        return $this->belongsTo(TalentCategory::class);
    }
}
