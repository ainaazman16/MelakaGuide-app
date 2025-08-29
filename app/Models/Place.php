<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;
    protected $table = 'places'; 

    protected $fillable = [
        'name',
        'category',
        'address',
        'phone',
        'website',
        'description',
        'image',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }

    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function assetFiles()
    {
        return $this->morphMany(\App\Models\AssetFile::class, 'reference');
    }
     // 🔹 Polymorphic relation to AssetFile
    public function assets()
    {
        return $this->morphMany(\App\Models\AssetFile::class, 'reference');
    }

    // 🔹 Shortcut: only cover image
    public function coverImage()
    {
        return $this->morphOne(\App\Models\AssetFile::class, 'reference')
                    ->where('category', 'cover');
    }

    // 🔹 Shortcut: gallery attachments
    public function gallery()
    {
        return $this->morphMany(\App\Models\AssetFile::class, 'reference')
                    ->where('category', 'gallery');
    }
}
