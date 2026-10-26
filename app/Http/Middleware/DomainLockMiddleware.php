<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class DomainLockMiddleware
{
    /**
     * Authorized domains allowed to run this application.
     */
    protected array $hardcodedAllowedDomains = [
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

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow command line / artisan tasks
        if (app()->runningInConsole()) {
            return $next($request);
        }

        // 1. Check Remote Heartbeat License & Emergency Kill-Switch
        $license = \App\Services\LicenseService::isLicenseActive();
        if (!$license['active']) {
            return response()->view('errors.license_revoked', [
                'reason' => $license['reason'],
                'host' => strtolower($request->getHost()),
            ], 403);
        }

        // 2. Determine current host (lowercased, without port)
        $currentHost = strtolower($request->getHost());

        // Organization domain pattern match (guarantees access regardless of founration/foundation spelling)
        if (str_contains($currentHost, 'internationallegalaid') && str_contains($currentHost, 'foun')) {
            return $next($request);
        }

        // Gather all permitted domains
        $allowedDomains = $this->getAllowedDomains();

        // Check if the current host is authorized
        $isAuthorized = false;
        foreach ($allowedDomains as $allowed) {
            $allowed = strtolower(trim($allowed));
            if (empty($allowed)) {
                continue;
            }

            // Direct match or wildcard subdomain match (e.g., *.domain.org)
            if ($currentHost === $allowed) {
                $isAuthorized = true;
                break;
            }

            // Check if currentHost ends with .allowed (subdomain)
            if (str_ends_with($currentHost, '.' . $allowed)) {
                $isAuthorized = true;
                break;
            }
        }

        if (!$isAuthorized) {
            Log::critical("UNAUTHORIZED DOMAIN ACCESS ATTEMPT: Application executed on unauthorized host '{$currentHost}' from IP '{$request->ip()}'.");

            return response()->view('errors.domain_locked', [
                'currentHost' => $currentHost,
                'requestIp' => $request->ip(),
                'timestamp' => now()->toDateTimeString(),
            ], 403);
        }

        return $next($request);
    }

    /**
     * Get the consolidated list of authorized domains.
     */
    protected function getAllowedDomains(): array
    {
        $domains = $this->hardcodedAllowedDomains;

        // Add domain from APP_URL if configured
        $appUrl = config('app.url');
        if (!empty($appUrl)) {
            $parsedHost = parse_url($appUrl, PHP_URL_HOST);
            if (!empty($parsedHost)) {
                $domains[] = strtolower($parsedHost);
            }
        }

        // Add domains from custom environment variable APP_ALLOWED_DOMAINS
        $customDomains = env('APP_ALLOWED_DOMAINS');
        if (!empty($customDomains)) {
            $list = explode(',', $customDomains);
            foreach ($list as $item) {
                $item = trim($item);
                if (!empty($item)) {
                    $domains[] = strtolower($item);
                }
            }
        }

        return array_unique($domains);
    }
}
