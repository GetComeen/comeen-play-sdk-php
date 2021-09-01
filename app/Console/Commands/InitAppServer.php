<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InitAppServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appserver:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The all-inclusive command you can use to setup your AppServer.';

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
    public function handle()
    {
        exec('sudo apt -y install curl nodejs build-essential git-all composer');
        exec('composer install -y');
//        Artisan::call('migrate', ['--queue' => 'default']);
        return 0;
    }
}
