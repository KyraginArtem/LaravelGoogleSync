<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SyncRecordController;

Route::resource('sync_records', SyncRecordController::class);
Route::get('sync_records/generate', [SyncRecordController::class, 'generate'])->name('sync_records.generate');
Route::get('sync_records/clear', [SyncRecordController::class, 'clear'])->name('sync_records.clear');
