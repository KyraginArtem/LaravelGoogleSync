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
        $this->client->setAuthConfig(storage_path('google-sheets.json'));
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
}
