<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GoogleSheetsService;
use App\Models\SyncRecord;

class SyncGoogleSheets extends Command
{
    protected $signature = 'sync:google-sheets';
    protected $description = 'Синхронизация данных с Google Sheets';

    protected $googleSheetsService;

    public function __construct(GoogleSheetsService $googleSheetsService)
    {
        parent::__construct();
        $this->googleSheetsService = $googleSheetsService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Запуск синхронизации данных...');

        $records = SyncRecord::allowed()->get();

        $data = [["ID", "Название", "Описание", "Статус"]];

        foreach ($records as $record) {
            $data[] = [
                $record->id,
                $record->name,
                $record->description,
                $record->status
            ];
        }

        $this->googleSheetsService->updateSheet($data, 'Sheet1!A1');

        $this->info('Данные успешно обновлены в Google Sheets!');
    }
}
