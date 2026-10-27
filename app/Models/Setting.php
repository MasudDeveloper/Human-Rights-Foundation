<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'key';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'key',
        'value',
    ];

    public static function defaults(): array
    {
        return [
            'site_logo' => 'images/org_logo_new.png',
            'site_favicon' => 'images/org_logo_new.png',
            'org_name_bn' => 'আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশন',
            'org_name_en' => 'INTERNATIONAL LEGAL AID & HUMAN RIGHTS FOUNDATION',
            'licence_no' => 'Licence No-s-15472/2026',
            'org_wing' => 'Worldwide Organization',
            'site_phone' => '01758343597',
            'site_email' => 'manushmanusherjonna@gmail.com',
            'site_website' => 'https://internationallegalaidhumanrightsfoundration.org',
            'site_address' => 'Head Office-37/2, Fayenez Bhabon, lift-08purana Paltan,culbut Road,dhaka',
            'site_slogan' => 'ন্যায় বিচার প্রতিষ্ঠায় আপোষহীন',
            'site_facebook' => 'https://facebook.com',
            'site_youtube' => 'https://youtube.com',
            'news_link' => '',
            'id_card_prefix' => '',
            'id_card_validity_years' => '2',
            'authorized_signature_name' => 'MOINUR RASHID CHOWDHURY',
            'authorized_signature_title' => 'Chairman',
            'authorized_signature_img' => '',
            'authorized_seal_img' => '',
            'id_card_emergency_contact' => '01758343597',
            'id_card_office_address' => '37/2, Fayenez Bhabon',
            'id_card_office_address_2' => 'lift-08purana Paltan,culbut Road,dhaka',
            'id_card_instructions' => "১. এই পরিচয়পত্রটি আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশনের সম্মানিত সদস্যের দাপ্তরিক পরিচয় হিসেবে গণ্য হবে।\n২. কার্ডটি অহস্তান্তরযোগ্য এবং কেবল অনুমোদিত মেয়াদকাল পর্যন্ত কার্যকর থাকবে।\n৩. সংস্থার গঠনতন্ত্র ও দেশের প্রচলিত আইনবিরোধী কোনো কাজে কার্ডের অপব্যবহার সম্পূর্ণ নিষিদ্ধ ও দণ্ডনীয়।\n৪. যেকোনো ধরণের বেআইনি আচরণে সংশ্লিষ্ট সদস্যের পদ বাতিল বলে গণ্য হবে।",
        ];
    }

    public static function get($key, $default = null)
    {
        $setting = static::find($key);
        if ($setting !== null && $setting->value !== null && $setting->value !== '') {
            return $setting->value;
        }
        $defaults = static::defaults();
        return $default ?? ($defaults[$key] ?? null);
    }

    public static function set($key, $value)
    {
        return static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function allKeyed(): array
    {
        $defaults = static::defaults();
        try {
            $dbSettings = static::pluck('value', 'key')->toArray();
            return array_merge($defaults, array_filter($dbSettings, fn($val) => $val !== null && $val !== ''));
        } catch (\Throwable $e) {
            return $defaults;
        }
    }

    public static function getLogoUrl(): string
    {
        $logo = static::get('site_logo');
        if ($logo && file_exists(public_path($logo))) {
            return asset($logo);
        }
        return asset('images/cit_logo.png');
    }

    public static function getFaviconUrl(): string
    {
        $favicon = static::get('site_favicon');
        if ($favicon && file_exists(public_path($favicon))) {
            return asset($favicon);
        }
        return asset('images/cit_logo.png');
    }

    public static function getSignatureUrl(): ?string
    {
        $sig = static::get('authorized_signature_img');
        if ($sig && file_exists(public_path($sig))) {
            return asset($sig);
        }
        return null;
    }

    public static function getSealUrl(): ?string
    {
        $seal = static::get('authorized_seal_img');
        if ($seal && file_exists(public_path($seal))) {
            return asset($seal);
        }
        return null;
    }
}

