<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SyncRecordController;

Route::resource('sync_records', SyncRecordController::class);
