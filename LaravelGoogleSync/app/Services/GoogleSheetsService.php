<?php


namespace App\Services;

use Google_Client;
use Google_Service_Sheets;

class GoogleSheetsService
{
    protected $client;
    protected $service;
    protected $spreadsheetId;

    public function __construct()
    {
        $this->spreadsheetId = env('GOOGLE_SHEETS_SPREADSHEET_ID');

        $this->client = new Google_Client();
        $googleCredentialsPath = storage_path('google-sheets.json');

        if (!file_exists($googleCredentialsPath)) {
            throw new \Exception("Файл учетных данных не найден: " . $googleCredentialsPath);
        }

        $this->client->setAuthConfig($googleCredentialsPath);

        $this->client->addScope(Google_Service_Sheets::SPREADSHEETS);

        $this->service = new Google_Service_Sheets($this->client);
    }

    public function updateSheet($data, $range = 'Sheet1!A1')
    {
        if (!$this->spreadsheetId) {
            throw new \Exception('Google Sheets ID не задан.');
        }

        $body = new \Google_Service_Sheets_ValueRange([
            'values' => $data
        ]);

        $params = ['valueInputOption' => 'RAW'];

        return $this->service->spreadsheets_values->update(
            $this->spreadsheetId,
            $range,
            $body,
            $params
        );
    }

    public function deleteRecord($recordId)
    {
        $spreadsheetId = env('GOOGLE_SHEETS_SPREADSHEET_ID');
        $range = 'Sheet1!A1:Z1000';

        // Загружаем текущие данные из Google Sheets
        $response = $this->service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();

        if (!$values) {
            return;
        }

        // Поиск строки с нужным ID
        $rowIndex = null;
        foreach ($values as $index => $row) {
            if (isset($row[0]) && $row[0] == $recordId) {
                $rowIndex = $index + 1;
                break;
            }
        }

        if ($rowIndex) {
            $deleteRange = "Sheet1!A$rowIndex:Z$rowIndex";
            $clearRequest = new \Google_Service_Sheets_ClearValuesRequest();
            $this->service->spreadsheets_values->clear($spreadsheetId, $deleteRange, $clearRequest);
        }
    }

    public function syncRecord(\App\Models\SyncRecord $record)
    {
        $spreadsheetId = env('GOOGLE_SHEETS_SPREADSHEET_ID');
        $range = 'Sheet1!A1';

        $data = [
            [$record->id, $record->name, $record->description, $record->status]
        ];

        $body = new \Google_Service_Sheets_ValueRange([
            'values' => $data
        ]);

        $params = ['valueInputOption' => 'RAW'];

        $this->service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);
    }

    public function fetchComments($count = 20): array
    {
        $spreadsheetId = env('GOOGLE_SHEETS_SPREADSHEET_ID');
        $range = 'Sheet1!A1:Z1000'; // Загружаем все данные

        $response = $this->service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();

        if (!$values) {
            return [];
        }

        $comments = [];
        foreach ($values as $row) {
            if (isset($row[0]) && isset($row[count($row) - 1])) {
                $comments[] = [
                    'id' => $row[0], // Первый столбец — ID записи
                    'comment' => $row[count($row) - 1] // Последний столбец — Комментарий
                ];
            }

            if (count($comments) >= $count) {
                break;
            }
        }

        return $comments;
    }

}
