<?php

namespace App\Jobs\GitHubWebhooks;

use App\Domain\Application\Model\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SebastianBergmann\Environment\Console;
use Spatie\GitHubWebhooks\Models\GitHubWebhookCall;
use Symplify\GitWrapper\GitWrapper;

class HandlePushWebhooks implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public GitHubWebhookCall $gitHubWebhookCall;

    public function __construct(
        public GitHubWebhookCall $webhookCall
    ) {}

    public function handle()
    {
        $url =  $this->webhookCall->payload('repository.url');
        $app = Application::where('options->repository', $url)->get()->first();
        Log::debug($app->name);
        $gitWrapper = new GitWrapper('git');
        $git = $gitWrapper->workingCopy($app->getOption('path'));
        Log::debug(print_r($git, true));
        Log::debug(print_r($gitWrapper, true));

        Log::debug('before pull');
        $git->pull();
        Log::debug('pulled');
        Log::debug('generating webpack config');

        Artisan::call('generate:webpack-config '. $app->id);
        Log::debug('webpack config generated');
        Log::debug('building modules');

        Artisan::call('build:application '. $app->id);
        Log::debug('Modules are built');

        return $app;
    }
}
