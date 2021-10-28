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
        $type =  $this->webhookCall->payload('repository.name');
        $app = Application::where('type', $type)->get()->first();

        return Artisan::call("application:sync $app->id");
    }
}
