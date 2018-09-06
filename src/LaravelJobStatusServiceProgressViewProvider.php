<?php

namespace Imtigger\LaravelJobStatus;

use Carbon\Carbon;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Queue\Events\JobExceptionOccurred;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Queue\QueueManager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class LaravelJobStatusServiceProgressViewProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'laravel-job-status');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'laravel-job-status');
        
        $this->publishes([
            __DIR__.'/resources/views/progress.blade.php' => resource_path('views/vendor/laravel-job-status/progress.blade.php'),
        ]);
    }
}
