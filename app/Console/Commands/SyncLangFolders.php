<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class SyncLangFolders extends Command
{
    protected $signature = 'lang:sync-folders';
    protected $description = 'Sync language folders with default English translations by Dr. Mogbojuri Babatunde';

    public function handle()
    {
        $locales = config('laravellocalization.supportedLocales');
        $langPath = resource_path('lang');
        $defaultLocale = 'en';

        $files = (new Filesystem)->allFiles($langPath . DIRECTORY_SEPARATOR . $defaultLocale);

        foreach ($locales as $locale => $details) {
            $localePath = $langPath . DIRECTORY_SEPARATOR . $locale;

            if (!is_dir($localePath)) {
                mkdir($localePath, 0755, true);
                $this->info("Created folder: $localePath");
            }

            foreach ($files as $file) {
                $relativePath = $file->getRelativePathname();
                $targetFile = $localePath . DIRECTORY_SEPARATOR . $relativePath;

                if (!is_dir(dirname($targetFile))) {
                    mkdir(dirname($targetFile), 0755, true);
                }

                $defaultArray = include $file->getPathname();
                $localeArray = file_exists($targetFile) ? include $targetFile : [];

                $updatedArray = array_merge($defaultArray, $localeArray);
                $missingKeys = array_diff_key($defaultArray, $localeArray);

                if (!empty($missingKeys)) {
                    $this->warn("Adding missing keys to {$locale}/{$relativePath}");
                }

                file_put_contents($targetFile, "<?php\n\nreturn " . var_export($updatedArray, true) . ";\n");
            }
        }

        $this->info('✅ All language folders synced successfully.');
        return Command::SUCCESS;
    }
}
