<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
class CreateActionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:action {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Data Girişi için Action oluşturma komutu';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $getFileName = $this->argument('name');
        $baseDir = app_path('Actions');

        $relativePath = str_replace('\\', '/', $getFileName);
        $fullPath = $baseDir . '/' . $relativePath . '.php';

        $className = class_basename($relativePath);
        $namespaceParts = explode('/', trim($relativePath, '/'));
        array_pop($namespaceParts); // remove class name

        $namespace = 'App\\Actions' . (count($namespaceParts) ? '\\' . implode('\\', $namespaceParts) : '');

        // Klasör varsa oluştur
        $directory = dirname($fullPath);
        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
            $this->info("Klasör Oluşturuldu: {$directory}");
        }

        // Dosya zaten varsa uyarı ver
        if (File::exists($fullPath)) {
            $this->error("Bu dosya zaten mevcut: {$fullPath}");
            return Command::FAILURE;
        }

        // İçeriği oluştur
        $stub = <<<PHP
<?php

namespace {$namespace};

class {$className}
{
    //
    public function handle(){


    }
}
PHP;

        File::put($fullPath, $stub);
        $this->info("DTO created: {$fullPath}");

        return Command::SUCCESS;
    }
}
