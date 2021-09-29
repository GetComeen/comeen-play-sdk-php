<?php

namespace App\Jobs\GitHubWebhooks;

use App\Domain\Application\Model\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Spatie\GitHubWebhooks\Jobs\ProcessGitHubWebhookJob;
use Spatie\GitHubWebhooks\Models\GitHubWebhookCall;
use Symplify\GitWrapper\GitWrapper;

class ProcessGitHubPushWebhook extends ProcessGitHubWebhookJob
{
    public function handle()
    {
        Log::debug('before processing job');
        parent::handle();


        Log::debug('after job being processed');
    }
}
