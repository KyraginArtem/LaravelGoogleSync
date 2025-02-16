<?php

namespace App\Http\Controllers;

use App\Models\SyncRecord;
use Illuminate\Http\Request;

class SyncRecordController extends Controller
{

    public function index()
    {
        $records = SyncRecord::all();
        return view('sync_records.index', compact('records'));
    }

    public function create()
    {
        return view('sync_records.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Allowed,Prohibited',
        ]);

        SyncRecord::create($request->all());

        return redirect()->route('sync_records.index')->with('success', 'Запись добавлена!');
    }

    public function show(SyncRecord $syncRecord)
    {
        return view('sync_records.show', compact('syncRecord'));
    }

    public function edit(SyncRecord $syncRecord)
    {
        return view('sync_records.edit', compact('syncRecord'));
    }

    public function update(Request $request, SyncRecord $syncRecord)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Allowed,Prohibited',
        ]);

        $syncRecord->update($request->all());

        return redirect()->route('sync_records.index')->with('success', 'Запись обновлена!');
    }

    public function destroy(SyncRecord $syncRecord)
    {
        $syncRecord->delete();
        return redirect()->route('sync_records.index')->with('success', 'Запись удалена!');
    }

    public function generate()
    {
        $statuses = ['Allowed', 'Prohibited'];

        $data = [];
        for ($i = 0; $i < 1000; $i++) {
            $data[] = [
                'name' => 'Запись ' . ($i + 1),
                'description' => 'Описание записи ' . ($i + 1),
                'status' => $statuses[array_rand($statuses)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('sync_records')->insert($data);

        return redirect()->route('sync_records.index')->with('success', '1000 записей добавлено!');
    }

    public function clear()
    {
        SyncRecord::truncate();
        return redirect()->route('sync_records.index')->with('success', 'Таблица очищена!');
    }
}
