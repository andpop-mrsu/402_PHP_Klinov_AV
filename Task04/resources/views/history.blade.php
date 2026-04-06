@extends('layout', ['title' => 'История игр'])

@section('content')
    @if ($rounds->isEmpty())
        <p class="muted">История пока пуста.</p>
    @else
        <table class="table">
            <thead>
            <tr>
                <th>Время</th>
                <th>Игрок</th>
                <th>Числа</th>
                <th>Ответ</th>
                <th>Результат</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($rounds as $round)
                <tr>
                    <td>{{ $round->created_at }}</td>
                    <td>{{ $round->player_name }}</td>
                    <td>{{ $round->a }}, {{ $round->b }}</td>
                    <td>{{ $round->answer }}</td>
                    <td>{{ $round->is_correct ? 'верно' : 'неверно' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection