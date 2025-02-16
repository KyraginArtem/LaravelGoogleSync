@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Комментарии из Google Sheets</h2>

        <form action="{{ url('/fetch') }}" method="GET" class="mb-3">
            <label for="count">Количество строк:</label>
            <input type="number" name="count" value="{{ $count }}" min="1" max="100" class="form-control w-25 d-inline">
            <button type="submit" class="btn btn-primary">Обновить</button>
        </form>

        @if(empty($comments))
            <div class="alert alert-warning">Нет данных для отображения.</div>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Комментарий</th>
                </tr>
                </thead>
                <tbody>
                @foreach($comments as $comment)
                    <tr>
                        <td>{{ $comment['id'] }}</td>
                        <td>{{ $comment['comment'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
