<?php

namespace App\Http\Controllers;

use App\Models\Round;
use Illuminate\View\View;

class HistoryController extends Controller
{
    public function index(): View
    {
        return view('history', [
            'rounds' => Round::query()
                ->latest()
                ->get(),
        ]);
    }
}