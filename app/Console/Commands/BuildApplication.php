<?php

namespace App\Console\Commands;

use App\Domain\Application\Model\Application;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Symfony\Component\Process\Process;


class BuildApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:application
                            {app-id : applications\'s id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Builds application based on each webpack.config.js.';

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
        $app = Application::find($this->argument('app-id'));

        $app->modules->each(function ($module) use ($app) {
            $file = $app->getOption('path') .'/'. $module->identifier .'.webpack.config.js';
            $process = Process::fromShellCommandline('webpack --config='. $file);
            echo 'webpack --config='. $file ."\n";
            $process->run();

            $file = $app->getOption('path') .'/'. $module->identifier .'-options.webpack.config.js';
            $process = Process::fromShellCommandline('webpack --config='. $file);
            echo 'webpack --config='. $file ."\n";
            $process->run();
        });

        return $app->id;
    }
}
