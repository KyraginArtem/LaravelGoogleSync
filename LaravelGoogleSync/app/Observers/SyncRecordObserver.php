<?php

namespace App\Observers;

use App\Models\SyncRecord;
use App\Services\GoogleSheetsService;

class SyncRecordObserver
{

    protected $googleSheetsService;

    public function __construct(GoogleSheetsService $googleSheetsService)
    {
        $this->googleSheetsService = $googleSheetsService;
    }

    /**
     * Handle the SyncRecord "created" event.
     *
     * @param  \App\Models\SyncRecord  $syncRecord
     * @return void
     */
    public function created(SyncRecord $syncRecord)
    {
        //
    }

    public function updating(SyncRecord $record)
    {
        if ($record->isDirty('status')) {
            if ($record->getOriginal('status') === 'Allowed' && $record->status === 'Prohibited') {
                $this->googleSheetsService->deleteRecord($record->id);
            }

            if ($record->getOriginal('status') === 'Prohibited' && $record->status === 'Allowed') {
                $this->googleSheetsService->syncRecord($record);
            }
        }
    }

    /**
     * Handle the SyncRecord "deleted" event.
     *
     * @param  \App\Models\SyncRecord  $syncRecord
     * @return void
     */
    public function deleted(SyncRecord $syncRecord)
    {
        //
    }

    /**
     * Handle the SyncRecord "restored" event.
     *
     * @param  \App\Models\SyncRecord  $syncRecord
     * @return void
     */
    public function restored(SyncRecord $syncRecord)
    {
        //
    }

    /**
     * Handle the SyncRecord "force deleted" event.
     *
     * @param  \App\Models\SyncRecord  $syncRecord
     * @return void
     */
    public function forceDeleted(SyncRecord $syncRecord)
    {
        //
    }
}
