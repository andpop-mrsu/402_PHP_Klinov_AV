<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        return view('home', [
            'playerName' => $request->session()->get('player_name'),
        ]);
    }

    public function setPlayer(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'player_name' => ['required', 'string', 'max:255'],
        ]);

        $request->session()->put('player_name', trim($validated['player_name']));

        return redirect('/play');
    }

    public function reset(Request $request): RedirectResponse
    {
        $request->session()->forget('player_name');

        return redirect('/');
    }
}