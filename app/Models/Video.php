<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $table = 'videos';

    protected $fillable = [
        'title',
        'youtube_url',
        'youtube_id',
        'category',
        'description',
        'sort_order',
        'is_active',
        'views_count',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'views_count' => 'integer',
    ];

    /**
     * Scope for active videos.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Parse YouTube ID from various YouTube URL formats.
     */
    public static function extractYoutubeId(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        $url = trim($url);

        // If user directly entered an 11-character YouTube video ID
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $url)) {
            return $url;
        }

        // Patterns covering youtube.com/watch?v=, youtu.be/, embed/, shorts/, live/
        $patterns = [
            '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/shorts\/|youtube\.com\/live\/)([a-zA-Z0-9_-]{11})/',
            '/^[a-zA-Z0-9_-]{11}$/'
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    /**
     * Mutator to automatically extract youtube_id when youtube_url is set.
     */
    public function setYoutubeUrlAttribute($value)
    {
        $this->attributes['youtube_url'] = $value;
        $id = self::extractYoutubeId($value);
        if ($id) {
            $this->attributes['youtube_id'] = $id;
        }
    }

    /**
     * Embed URL for iframe.
     */
    public function getEmbedUrlAttribute(): string
    {
        $id = $this->youtube_id ?: self::extractYoutubeId($this->youtube_url);
        return $id ? "https://www.youtube-nocookie.com/embed/{$id}?rel=0" : '';
    }

    /**
     * High quality thumbnail URL.
     */
    public function getThumbnailUrlAttribute(): string
    {
        $id = $this->youtube_id ?: self::extractYoutubeId($this->youtube_url);
        return $id ? "https://img.youtube.com/vi/{$id}/hqdefault.jpg" : asset('images/cit_logo.png');
    }

    /**
     * Clean watch URL.
     */
    public function getWatchUrlAttribute(): string
    {
        $id = $this->youtube_id ?: self::extractYoutubeId($this->youtube_url);
        return $id ? "https://www.youtube.com/watch?v={$id}" : $this->youtube_url;
    }
}
