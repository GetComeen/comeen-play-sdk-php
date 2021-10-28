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


class SyncApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'application:sync
                            {app_id : applications\'s id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize an application for the given id.';

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
        $app_id = $this->argument('app_id');
        $app = Application::with(['modules', 'bundles', 'builds.privileges', 'authorizations'])->find($app_id);

        if (!$app || !$app->auto_sync) {
            return 0;
        }

        echo "Syncing: $app->type\n";
        try {
            $importer = ApplicationImporterInstance::get($app->import_type, $app);
            $app = $importer->sync();
        } catch (\Exception $e) {
//            $importer->cancelImport();
            echo "Application sync has failed: ". $e->getMessage() ."\n";
            return 0;
        }

        echo "App \"$app->type\" has been successfully synced\n";

        return $app->id;
    }
}
