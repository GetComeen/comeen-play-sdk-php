<?php

namespace App\Domain\Application\Observer;

use App\Domain\Application\Model\Application;
use Illuminate\Support\Facades\Storage;

class ApplicationObserver
{
    public function created(Application $app)
    {

    }

    public function deleted(Application $app)
    {
        $path = $app->getOption('path');
        Storage::disk('apps')->deleteDirectory($path);
    }

}
