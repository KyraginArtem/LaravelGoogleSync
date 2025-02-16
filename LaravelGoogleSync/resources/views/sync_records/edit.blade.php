<?php


@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Редактировать запись</h2>
        <form action="{{ route('sync_records.update', $syncRecord) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Название</label>
                <input type="text" name="name" class="form-control" value="{{ $syncRecord->name }}" required>
            </div>
            <div class="form-group">
                <label>Описание</label>
                <textarea name="description" class="form-control">{{ $syncRecord->description }}</textarea>
            </div>
            <div class="form-group">
                <label>Статус</label>
                <select name="status" class="form-control">
                    <option value="Allowed" {{ $syncRecord->status == 'Allowed' ? 'selected' : '' }}>Allowed</option>
                    <option value="Prohibited" {{ $syncRecord->status == 'Prohibited' ? 'selected' : '' }}>Prohibited</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Обновить</button>
        </form>
    </div>
@endsection
