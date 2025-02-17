@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Список записей</h2>
        <a href="{{ route('sync_records.create') }}" class="btn btn-primary">Добавить запись</a>
        <form action="{{ route('sync_records.generate') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Создать 1000 записей</button>
        </form>
        <form action="{{ route('sync_records.clear') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Очистить</button>
        </form>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($records as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->name }}</td>
                    <td>{{ $record->status }}</td>
                    <td>
                        <a href="{{ route('sync_records.edit', $record) }}" class="btn btn-warning">Редактировать</a>
                        <form action="{{ route('sync_records.destroy', $record) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

