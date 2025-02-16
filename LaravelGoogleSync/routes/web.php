<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SyncRecordController;
use App\Services\GoogleSheetsService;

Route::resource('sync_records', SyncRecordController::class);
Route::get('sync_records/generate', [SyncRecordController::class, 'generate'])->name('sync_records.generate');
Route::get('sync_records/clear', [SyncRecordController::class, 'clear'])->name('sync_records.clear');

Route::get('/test-google-sheets', function (GoogleSheetsService $googleSheetsService) {
    try {
        $data = [
            ["ID", "Название", "Описание", "Статус"],
            [1, "Тестовая запись", "Описание тестовой записи", "Allowed"]
        ];

        $googleSheetsService->updateSheet($data, 'Sheet1!A1');

        return "Данные успешно отправлены в Google Sheets!";
    } catch (\Exception $e) {
        return "Ошибка: " . $e->getMessage();
    }
});
