<?php


@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Добавить запись</h2>
        <form action="{{ route('sync_records.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Название</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Описание</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label>Статус</label>
                <select name="status" class="form-control">
                    <option value="Allowed">Allowed</option>
                    <option value="Prohibited">Prohibited</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Сохранить</button>
        </form>
    </div>
@endsection

