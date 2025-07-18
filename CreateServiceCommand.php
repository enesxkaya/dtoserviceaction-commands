<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Servis oluşturma komutu';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $getFileName = $this->argument('name');
        $baseDir = app_path('Services');

        $relativePath = str_replace('\\', '/', $getFileName);
        $fullPath = $baseDir . '/' . $relativePath . '.php';

        $className = class_basename($relativePath);
        $namespaceParts = explode('/', trim($relativePath, '/'));
        array_pop($namespaceParts); // remove class name

        $namespace = 'App\\Services' . (count($namespaceParts) ? '\\' . implode('\\', $namespaceParts) : '');

        // Klasör varsa oluştur
        $directory = dirname($fullPath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
            $this->info("Klasör Oluşturuldu: {$directory}");
        }

        // Dosya zaten varsa uyarı ver
        if (file_exists($fullPath)) {
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
}

PHP;

        // Dosyayı yaz
        file_put_contents($fullPath, $stub);
        $this->info("Servis dosyası oluşturuldu: {$fullPath}");

        return Command::SUCCESS;    
    }
}
