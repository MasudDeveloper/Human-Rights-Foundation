<?php
/**
 * Standalone Shared Hosting Migration & Cache Clearing Runner
 */
define('LARAVEL_START', microtime(true));

// Autoload & Bootstrap detection for standard Laravel or shared hosting public/public_html
$autoload = file_exists(__DIR__ . '/../vendor/autoload.php') ? __DIR__ . '/../vendor/autoload.php' : __DIR__ . '/vendor/autoload.php';
$bootstrap = file_exists(__DIR__ . '/../bootstrap/app.php') ? __DIR__ . '/../bootstrap/app.php' : __DIR__ . '/bootstrap/app.php';

if (!file_exists($autoload) || !file_exists($bootstrap)) {
    die("<div style='font-family:sans-serif;padding:20px;color:red;'>Could not locate vendor/autoload.php or bootstrap/app.php</div>");
}

require $autoload;
$app = require_once $bootstrap;

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "<!DOCTYPE html><html lang='bn'><head><meta charset='utf-8'><title>মাইগ্রেশন ও ক্যাশ ক্লিয়ার</title></head><body style='background:#f8fafc;font-family:Segoe UI,Tahoma,Geneva,Verdana,sans-serif;'>";

try {
    // 1. Run Migrations
    Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    $migrateOutput = Illuminate\Support\Facades\Artisan::output();

    // 2. Clear all cached configurations, views and routes
    Illuminate\Support\Facades\Artisan::call('optimize:clear');
    $clearOutput = Illuminate\Support\Facades\Artisan::output();

    echo "<div style='max-width:680px;margin:40px auto;background:#ffffff;border:1px solid #86efac;border-radius:16px;box-shadow:0 10px 25px -5px rgba(0,0,0,0.05);overflow:hidden;'>
        <div style='background:#16a34a;color:#ffffff;padding:20px 24px;'>
            <h2 style='margin:0;font-size:20px;'>✅ মাইগ্রেশন ও ক্যাশ ক্লিয়ার সফল হয়েছে!</h2>
            <p style='margin:6px 0 0;font-size:13px;opacity:0.9;'>ডাটাবেজ মাইগ্রেশন সম্পন্ন হয়েছে এবং রাউট/ভিউ ক্যাশ মুছে ফেলা হয়েছে।</p>
        </div>
        <div style='padding:24px;'>
            <h4 style='margin:0 0 8px;font-size:14px;color:#334155;'>কমান্ড আউটপুট:</h4>
            <pre style='background:#f1f5f9;border:1px solid #cbd5e1;padding:16px;border-radius:10px;font-size:13px;color:#0f172a;white-space:pre-wrap;font-family:Consolas,Monaco,monospace;line-height:1.5;'>" . htmlspecialchars($migrateOutput ?: "Nothing to migrate.\n") . "\n" . htmlspecialchars($clearOutput) . "</pre>
            <div style='margin-top:20px;text-align:right;'>
                <a href='/' style='display:inline-block;padding:10px 20px;background:#0f172a;color:#fbbf24;text-decoration:none;border-radius:10px;font-weight:bold;font-size:13px;'>হোমপেজে ফিরে যান →</a>
            </div>
        </div>
    </div>";
} catch (\Throwable $e) {
    echo "<div style='max-width:680px;margin:40px auto;background:#ffffff;border:1px solid #fca5a5;border-radius:16px;box-shadow:0 10px 25px -5px rgba(0,0,0,0.05);overflow:hidden;'>
        <div style='background:#dc2626;color:#ffffff;padding:20px 24px;'>
            <h2 style='margin:0;font-size:20px;'>❌ মাইগ্রেশন রান করতে সমস্যা হয়েছে</h2>
        </div>
        <div style='padding:24px;'>
            <pre style='background:#fef2f2;border:1px solid #fecaca;padding:16px;border-radius:10px;font-size:13px;color:#991b1b;white-space:pre-wrap;font-family:Consolas,Monaco,monospace;'>" . htmlspecialchars($e->getMessage()) . "</pre>
        </div>
    </div>";
}

echo "</body></html>";
