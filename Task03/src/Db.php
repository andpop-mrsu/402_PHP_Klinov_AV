<?php

declare(strict_types=1);

namespace NevallvonGoodem\Task03\Db;

use PDO;

function pdo(): PDO
{
    $path = __DIR__ . '/../db/gcd.sqlite';

    $pdo = new PDO('sqlite:' . $path);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('PRAGMA foreign_keys = ON');

    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS games (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            player_name TEXT NOT NULL,
            started_at TEXT NOT NULL
        )'
    );

    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS steps (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            game_id INTEGER NOT NULL,
            created_at TEXT NOT NULL,
            a INTEGER NOT NULL,
            b INTEGER NOT NULL,
            correct_gcd INTEGER NOT NULL,
            answer INTEGER NOT NULL,
            is_correct INTEGER NOT NULL,
            FOREIGN KEY(game_id) REFERENCES games(id) ON DELETE CASCADE
        )'
    );

    return $pdo;
}
