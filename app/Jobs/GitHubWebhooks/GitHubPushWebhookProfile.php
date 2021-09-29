<?php

use Illuminate\Http\Request;
use Spatie\WebhookClient\Models\WebhookCall;
use Spatie\WebhookClient\WebhookProfile\WebhookProfile;

class GitHubPushWebhookProfile implements WebhookProfile
{
    public function shouldProcess(Request $request): bool
    {
        
        return ! WebhookCall::where('payload->id', $request->get('id'))->exists();
    }
}
