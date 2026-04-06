<?php

namespace App\Http\Controllers;

use App\Models\Round;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GameController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        $playerName = $request->session()->get('player_name');

        if ($playerName === null || $playerName === '') {
            return redirect('/');
        }

        $a = random_int(1, 100);
        $b = random_int(1, 100);

        $request->session()->put('current_round', [
            'a' => $a,
            'b' => $b,
        ]);

        return view('play', [
            'playerName' => $playerName,
            'a' => $a,
            'b' => $b,
            'result' => null,
        ]);
    }

    public function submit(Request $request): View|RedirectResponse
    {
        $playerName = $request->session()->get('player_name');
        $round = $request->session()->get('current_round');

        if ($playerName === null || $round === null) {
            return redirect('/');
        }

        $validated = $request->validate([
            'answer' => ['required', 'integer'],
        ]);

        $a = (int) $round['a'];
        $b = (int) $round['b'];
        $answer = (int) $validated['answer'];
        $correctGcd = $this->gcd($a, $b);
        $isCorrect = $answer === $correctGcd;

        Round::create([
            'player_name' => $playerName,
            'a' => $a,
            'b' => $b,
            'correct_gcd' => $correctGcd,
            'answer' => $answer,
            'is_correct' => $isCorrect,
        ]);

        return view('play', [
            'playerName' => $playerName,
            'a' => $a,
            'b' => $b,
            'result' => [
                'answer' => $answer,
                'correct_gcd' => $correctGcd,
                'is_correct' => $isCorrect,
            ],
        ]);
    }

    private function gcd(int $a, int $b): int
    {
        $a = abs($a);
        $b = abs($b);

        while ($b !== 0) {
            [$a, $b] = [$b, $a % $b];
        }

        return $a;
    }
}