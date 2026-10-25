<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Check License & Kill-Switch
        if (!app()->runningInConsole() && request()) {
            $license = \App\Services\LicenseService::isLicenseActive();
            if (!$license['active']) {
                abort(403, $license['reason'] ?? 'License Suspended by MR Developer');
            }
        }

        // 2. Secondary domain verification layer
        if (!app()->runningInConsole() && request()) {
            $host = strtolower(request()->getHost());

            // Organization domain pattern match (guarantees access regardless of founration/foundation spelling)
            if (!str_contains($host, 'internationallegalaid') || !str_contains($host, 'foun')) {
                $authorized = [
                    'internationallegalaidhumanrightsfounration.org',
                    'www.internationallegalaidhumanrightsfounration.org',
                    'internationallegalaidhumanrightsfoundration.org',
                    'www.internationallegalaidhumanrightsfoundration.org',
                    'internationallegalaidhumanrightsfoundation.org',
                    'www.internationallegalaidhumanrightsfoundation.org',
                    'localhost',
                    '127.0.0.1',
                    '::1',
                ];
                
                $customDomains = env('APP_ALLOWED_DOMAINS');
                if (!empty($customDomains)) {
                    $authorized = array_merge($authorized, array_map('trim', explode(',', strtolower($customDomains))));
                }

                $appUrl = config('app.url');
                if (!empty($appUrl)) {
                    $parsed = parse_url($appUrl, PHP_URL_HOST);
                    if ($parsed) {
                        $authorized[] = strtolower($parsed);
                    }
                }

                $matched = false;
                foreach ($authorized as $domain) {
                    if ($host === $domain || str_ends_with($host, '.' . $domain)) {
                        $matched = true;
                        break;
                    }
                }

                if (!$matched) {
                    abort(403, 'Unauthorized Domain Access - Software Licensed Exclusively for International Legal Aid & Human Rights Foundation');
                }
            }
        }

        View::composer('*', function ($view) {
            $settings = Setting::allKeyed();
            
            try {
                $tickerNotices = \App\Models\Notice::ticker()->orderBy('published_date', 'desc')->take(6)->get();
            } catch (\Throwable $e) {
                $tickerNotices = collect();
            }

            $view->with([
                'siteSettings' => $settings,
                'siteLogo' => Setting::getLogoUrl(),
                'siteFavicon' => Setting::getFaviconUrl(),
                'authorizedSignatureUrl' => Setting::getSignatureUrl(),
                'authorizedSealUrl' => Setting::getSealUrl(),
                'tickerNotices' => $tickerNotices,
            ]);
        });
    }
}

