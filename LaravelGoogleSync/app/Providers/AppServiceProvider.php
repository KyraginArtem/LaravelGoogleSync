<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\SyncRecord;
use App\Observers\SyncRecordObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        SyncRecord::observe(SyncRecordObserver::class);
    }
}
