<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ObfuscateCodeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'code:obfuscate 
                            {path : Path to PHP file or directory (relative to base path)}
                            {--restore : Restore original files from backup}
                            {--backup-only : Only create backups without obfuscating}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Obfuscate and protect PHP source code against theft and reverse-engineering';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $target = $this->argument('path');
        $fullPath = base_path($target);

        if (!File::exists($fullPath)) {
            $this->error("Path does not exist: {$target}");
            return 1;
        }

        $backupDir = storage_path('obfuscate_backups');
        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        if ($this->option('restore')) {
            return $this->restorePath($fullPath, $backupDir);
        }

        if (File::isDirectory($fullPath)) {
            $files = File::allFiles($fullPath);
            $count = 0;
            foreach ($files as $file) {
                if ($file->getExtension() === 'php') {
                    $this->obfuscateFile($file->getRealPath(), $backupDir);
                    $count++;
                }
            }
            $this->info("Successfully processed and obfuscated {$count} PHP files in '{$target}'.");
        } else {
            if (pathinfo($fullPath, PATHINFO_EXTENSION) !== 'php') {
                $this->error("Target file must be a .php file.");
                return 1;
            }
            $this->obfuscateFile($fullPath, $backupDir);
            $this->info("Successfully obfuscated: {$target}");
        }

        $this->comment("Original backups stored securely at: storage/obfuscate_backups/");
        $this->comment("To restore original code anytime: php artisan code:obfuscate {$target} --restore");

        return 0;
    }

    /**
     * Obfuscate a single PHP file.
     */
    protected function obfuscateFile(string $filePath, string $backupDir): void
    {
        $content = File::get($filePath);

        // Check if already obfuscated
        if (str_contains($content, '/* PROTECTED_BY_GUARD */')) {
            $this->line("Skipping (already obfuscated): " . basename($filePath));
            return;
        }

        // 1. Create a safe backup
        $relPath = str_replace(base_path() . DIRECTORY_SEPARATOR, '', $filePath);
        $backupFile = $backupDir . DIRECTORY_SEPARATOR . md5($relPath) . '_' . basename($filePath);
        File::put($backupFile, $content);

        if ($this->option('backup-only')) {
            $this->line("Backed up: {$relPath}");
            return;
        }

        // 2. Remove PHP tags to get pure code payload
        $cleanCode = preg_replace('/^<\?php\s*/i', '', $content);
        $cleanCode = preg_replace('/\?>\s*$/i', '', $cleanCode);

        // 3. Compress and encode
        $compressed = gzdeflate($cleanCode, 9);
        $encoded = base64_encode($compressed);
        $hash = hash('sha256', $encoded);

        // 4. Generate random variable identifiers
        $vPayload = '$_' . bin2hex(random_bytes(3));
        $vHash = '$_' . bin2hex(random_bytes(3));
        $vInflate = '$_' . bin2hex(random_bytes(3));

        // 5. Build tamper-proof obfuscation wrapper
        $obfuscatedCode = "<?php\n/* PROTECTED_BY_GUARD */\n";
        $obfuscatedCode .= "/* Anti-Tamper & Proprietary Copyright Shield */\n";
        $obfuscatedCode .= "{$vPayload} = '{$encoded}';\n";
        $obfuscatedCode .= "{$vHash} = '{$hash}';\n";
        $obfuscatedCode .= "if(hash('sha256', {$vPayload}) !== {$vHash}) { die('Integrity Violation: Source code modified.'); }\n";
        $obfuscatedCode .= "{$vInflate} = gzinflate(base64_decode({$vPayload}));\n";
        $obfuscatedCode .= "eval({$vInflate});\n";

        File::put($filePath, $obfuscatedCode);
        $this->line("<info>Protected:</info> " . $relPath);
    }

    /**
     * Restore original files from backup.
     */
    protected function restorePath(string $fullPath, string $backupDir): int
    {
        if (File::isDirectory($fullPath)) {
            $files = File::allFiles($fullPath);
            $restored = 0;
            foreach ($files as $file) {
                if ($this->restoreFile($file->getRealPath(), $backupDir)) {
                    $restored++;
                }
            }
            $this->info("Restored {$restored} files from backup.");
        } else {
            if ($this->restoreFile($fullPath, $backupDir)) {
                $this->info("Restored file successfully.");
            } else {
                $this->error("Backup file not found for this target.");
                return 1;
            }
        }
        return 0;
    }

    /**
     * Restore a single file from backup.
     */
    protected function restoreFile(string $filePath, string $backupDir): bool
    {
        $relPath = str_replace(base_path() . DIRECTORY_SEPARATOR, '', $filePath);
        $backupFile = $backupDir . DIRECTORY_SEPARATOR . md5($relPath) . '_' . basename($filePath);

        if (File::exists($backupFile)) {
            File::put($filePath, File::get($backupFile));
            $this->line("<comment>Restored:</comment> " . $relPath);
            return true;
        }

        return false;
    }
}
