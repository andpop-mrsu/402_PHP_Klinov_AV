@extends('layout', ['title' => 'Игра: НОД'])

@section('content')
    <p><span class="badge">Игрок: {{ $playerName }}</span></p>
    <p>Найдите НОД чисел: <b>{{ $a }}</b> и <b>{{ $b }}</b></p>

    @if ($result !== null)
        @if ($result['is_correct'])
            <p><span class="badge ok">Верно</span></p>
        @else
            <p>
                <span class="badge bad">Неверно</span>
                Правильный ответ: <b>{{ $result['correct_gcd'] }}</b>
            </p>
        @endif

        <p><a class="btn" href="/play">Сыграть ещё</a></p>
    @else
        <form method="post" action="/play">
            @csrf
            <p>
                <input class="input" type="number" name="answer" placeholder="Ваш ответ" required>
            </p>
            <p>
                <button class="btn" type="submit">Ответить</button>
            </p>
        </form>
    @endif
@endsection