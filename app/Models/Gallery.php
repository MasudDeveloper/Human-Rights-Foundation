<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'galleries';

    protected $fillable = [
        'title',
        'category',
        'image_path',
        'description',
        'event_date',
        'sort_order',
        'is_active',
        'views_count',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'event_date' => 'date',
        'sort_order' => 'integer',
        'views_count' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image_path) {
            return asset('images/crime_banner.jpg');
        }

        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            return $this->image_path;
        }

        return asset($this->image_path);
    }

    public function getFormattedDateAttribute()
    {
        if ($this->event_date) {
            return Carbon::parse($this->event_date)->translatedFormat('d F, Y');
        }

        return $this->created_at->translatedFormat('d F, Y');
    }
}
