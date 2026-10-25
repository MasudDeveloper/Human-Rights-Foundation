<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'description',
        'file_path',
        'file_name',
        'file_size',
        'published_date',
        'is_active',
        'is_ticker',
        'views_count',
        'created_by',
    ];

    protected $casts = [
        'published_date' => 'date',
        'is_active' => 'boolean',
        'is_ticker' => 'boolean',
        'views_count' => 'integer',
    ];

    /**
     * Scope active notices
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope notices displayed in the ticker
     */
    public function scopeTicker($query)
    {
        return $query->where('is_active', true)->where('is_ticker', true);
    }

    /**
     * Check if notice has an attached file
     */
    public function getHasFileAttribute(): bool
    {
        return !empty($this->file_path);
    }

    /**
     * Check if attached file is a PDF
     */
    public function getIsPdfAttribute(): bool
    {
        if (empty($this->file_path)) {
            return false;
        }
        return str_ends_with(strtolower($this->file_path), '.pdf');
    }

    /**
     * Formatted file URL
     */
    public function getFileUrlAttribute(): ?string
    {
        return $this->file_path ? asset($this->file_path) : null;
    }

    /**
     * Formatted Bengali Date
     */
    public function getFormattedDateAttribute(): string
    {
        if (!$this->published_date) {
            return '';
        }

        $date = Carbon::parse($this->published_date);
        $enMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $bnMonths = ['জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];

        $day = self::en2bn($date->format('d'));
        $month = str_replace($enMonths, $bnMonths, $date->format('F'));
        $year = self::en2bn($date->format('Y'));

        return "{$day} {$month}, {$year}";
    }

    /**
     * Badge styles by category
     */
    public function getCategoryBadgeAttribute(): array
    {
        return match ($this->category) {
            'জরুরি বিজ্ঞপ্তি' => ['bg' => 'bg-rose-100 text-rose-800 border-rose-200', 'icon' => 'fa-solid fa-triangle-exclamation'],
            'সাধারণ নোটিশ' => ['bg' => 'bg-blue-100 text-blue-800 border-blue-200', 'icon' => 'fa-solid fa-bullhorn'],
            'প্রেস বিজ্ঞপ্তি' => ['bg' => 'bg-emerald-100 text-emerald-800 border-emerald-200', 'icon' => 'fa-solid fa-newspaper'],
            'আইনি নির্দেশনা' => ['bg' => 'bg-purple-100 text-purple-800 border-purple-200', 'icon' => 'fa-solid fa-scale-balanced'],
            default => ['bg' => 'bg-amber-100 text-amber-900 border-amber-200', 'icon' => 'fa-solid fa-circle-info'],
        };
    }

    /**
     * English to Bengali numeral converter
     */
    public static function en2bn($number): string
    {
        $en = ['0','1','2','3','4','5','6','7','8','9'];
        $bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
        return str_replace($en, $bn, (string)$number);
    }
}
