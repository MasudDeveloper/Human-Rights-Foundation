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
        View::composer('*', function ($view) {
            try {
                $settings = Setting::allKeyed();
                $logo = Setting::getLogoUrl();
                $favicon = Setting::getFaviconUrl();
                $signature = Setting::getSignatureUrl();
                $seal = Setting::getSealUrl();
                $tickerNotices = \App\Models\Notice::ticker()->orderBy('published_date', 'desc')->take(6)->get();
            } catch (\Throwable $e) {
                $settings = [];
                $logo = asset('images/org_logo_new.png');
                $favicon = asset('images/org_logo_new.png');
                $signature = '';
                $seal = '';
                $tickerNotices = collect();
            }

            $view->with([
                'siteSettings' => $settings,
                'siteLogo' => $logo,
                'siteFavicon' => $favicon,
                'authorizedSignatureUrl' => $signature,
                'authorizedSealUrl' => $seal,
                'tickerNotices' => $tickerNotices,
            ]);
        });
    }
}
