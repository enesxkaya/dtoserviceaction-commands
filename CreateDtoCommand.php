<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CreateDtoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:dto {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Data girişi için DTO oluşturma komutu';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $getFileName = $this->argument('name');
        $baseDir = app_path('Dto');

        $relativePath = str_replace('\\', '/', $getFileName);
        $fullPath = $baseDir . '/' . $relativePath . '.php';

        $className = class_basename($relativePath);
        $namespaceParts = explode('/', trim($relativePath, '/'));
        array_pop($namespaceParts); // remove class name

        $namespace = 'App\\Dto' . (count($namespaceParts) ? '\\' . implode('\\', $namespaceParts) : '');

        // Klasör varsa oluştur
        $directory = dirname($fullPath);
        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
            $this->info("Folder Created: {$directory}");
        }

        // Dosya zaten varsa uyarı ver
        if (File::exists($fullPath)) {
            $this->error("File exists: {$fullPath}");
            return Command::FAILURE;
        }

        // İçeriği oluştur
        $stub = <<<PHP
<?php

namespace {$namespace};

readonly class {$className}
{
    //
}
PHP;

        File::put($fullPath, $stub);
        $this->info("DTO created: {$fullPath}");

        return Command::SUCCESS;
    }
}
