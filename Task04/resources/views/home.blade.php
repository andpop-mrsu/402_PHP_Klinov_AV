@extends('layout', ['title' => 'GCD Game'])

@section('content')
    @if ($playerName)
        <p><span class="badge">Текущий игрок: {{ $playerName }}</span></p>
        <p><a class="btn" href="/play">Начать игру</a></p>
    @else
        <p class="muted">Введите имя, чтобы начать игру.</p>

        <form method="post" action="/player">
            @csrf
            <p>
                <input class="input" type="text" name="player_name" placeholder="Имя" required>
            </p>
            <p>
                <button class="btn" type="submit">Сохранить имя</button>
            </p>
        </form>
    @endif
@endsection