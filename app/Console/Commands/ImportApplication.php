<?php

namespace App\Console\Commands;

use App\Domain\Application\Importer\ApplicationImporter;
use App\Domain\Application\Importer\ApplicationImporterInstance;
use App\Domain\Application\Importer\UrlImporter;
use App\Domain\Application\Model\Application;
use App\Domain\Build\Model\Build;
use App\Domain\Module\Model\Module;
use App\Domain\Privilege\Model\Privilege;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Facades\Storage;


class ImportApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'application:import
                            {--type= : [url, path, zip]}
                            {src : application\'s path or url according to the type of import}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import an application for the given path/url.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $type = $this->option('type');
        $src = $this->argument('src');

        echo "$type: $src\n";

        try {
            $importer = ApplicationImporterInstance::get($type);
            $app = $importer->import($src);
        } catch (\Exception $e) {
            $importer->cancelImport();
            echo "Application import has failed: ". $e->getMessage() ."\n";
            return 0;
        }

        echo "App \"$app->name\" has been successfully imported\n";

        return $app->id;
    }
}
