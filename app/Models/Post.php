<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $fillable = ['title','content','user_id'];
    protected static function booted()
    {
        static::creating(function ($post) {
            $post->slug = self::generateUniqueSlug($post->title);
            $post->user_id = auth()->id();
            $post->guard_used = auth()->getDefaultDriver(); 
        });

        static::updating(function ($post) {
            if ($post->isDirty('title')) {
                $post->slug = self::generateUniqueSlug($post->title);
               $post->guard_used = auth()->getDefaultDriver(); 
            }
        });
    }

    protected static function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $count = 1;

        while (self::where('slug', $slug)->exists()) {
            $slug = Str::slug($title) . '-' . $count++;
        }

        return $slug;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}