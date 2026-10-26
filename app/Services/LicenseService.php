<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LicenseService
{
    const CACHE_KEY = 'app_remote_license_status';
    const CACHE_REASON_KEY = 'app_remote_license_reason';

    /**
     * Check if the application license is currently active.
     */
    public static function isLicenseActive(): array
    {
        // 1. Immediate local emergency kill-switch in .env
        if (env('LICENSE_KILL_SWITCH', false) === true || env('LICENSE_KILL_SWITCH') === 'true') {
            return [
                'active' => false,
                'reason' => 'সফটওয়্যার লাইসেন্স ডেভেলপার কর্তৃক জরুরি ভিত্তিতে স্থগিত করা হয়েছে (Local Kill-Switch Triggered).'
            ];
        }

        // 2. Check cached verification status to avoid latency
        if (Cache::has(self::CACHE_KEY)) {
            $status = Cache::get(self::CACHE_KEY);
            if ($status === 'suspended' || $status === 'revoked') {
                return [
                    'active' => false,
                    'reason' => Cache::get(self::CACHE_REASON_KEY, 'লাইসেন্স নবায়ন বা পেমেন্ট সংক্রান্ত কারণে লাইসেন্স স্থগিত করা হয়েছে।')
                ];
            }
            if ($status === 'active') {
                return ['active' => true, 'reason' => null];
            }
        }

        // 3. Remote Heartbeat API Check
        $remoteUrl = env('LICENSE_SERVER_URL');

        // If no remote URL is configured, default to active
        if (empty($remoteUrl)) {
            Cache::put(self::CACHE_KEY, 'active', now()->addHours(24));
            return ['active' => true, 'reason' => null];
        }

        try {
            $currentHost = strtolower(request()->getHost());
            $response = Http::timeout(2)
                ->withHeaders([
                    'User-Agent' => 'LicenseGuard-Heartbeat/2.0',
                    'X-App-Host' => $currentHost,
                ])
                ->get($remoteUrl, [
                    'domain' => $currentHost,
                    'version' => '1.0.0',
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $status = strtolower($data['status'] ?? $data['license_status'] ?? 'active');
                $reason = $data['reason'] ?? $data['message'] ?? 'লাইসেন্স সাময়িকভাবে স্থগিত করা হয়েছে।';

                if ($status === 'suspended' || $status === 'revoked' || $status === 'blocked') {
                    Cache::put(self::CACHE_KEY, 'suspended', now()->addHours(6));
                    Cache::put(self::CACHE_REASON_KEY, $reason, now()->addHours(6));

                    Log::warning("REMOTE KILL-SWITCH ACTIVATED for host '{$currentHost}'. Reason: {$reason}");

                    return [
                        'active' => false,
                        'reason' => $reason
                    ];
                }

                // If remote says active
                Cache::put(self::CACHE_KEY, 'active', now()->addHours(12));
                return ['active' => true, 'reason' => null];
            }
        } catch (\Throwable $e) {
            // In case of remote server timeout or temporary network downtime,
            // gracefully allow application to continue for up to 24 hours
            Log::info('Remote license heartbeat check skipped (network timeout): ' . $e->getMessage());
            Cache::put(self::CACHE_KEY, 'active', now()->addHours(12));
            return ['active' => true, 'reason' => null];
        }

        return ['active' => true, 'reason' => null];
    }
}
