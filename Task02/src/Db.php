<?php

declare(strict_types=1);

namespace NevallvonGoodem\Task02\Db;

use PDO;

function pdo(): PDO
{
    $path = __DIR__ . '/../db/gcd.sqlite';
    $pdo = new PDO('sqlite:' . $path);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS rounds (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            played_at TEXT NOT NULL,
            player_name TEXT NOT NULL,
            a INTEGER NOT NULL,
            b INTEGER NOT NULL,
            correct_gcd INTEGER NOT NULL,
            answer INTEGER NOT NULL,
            is_correct INTEGER NOT NULL
        )'
    );

    return $pdo;
}

function insertRound(
    PDO $pdo,
    string $playedAt,
    string $playerName,
    int $a,
    int $b,
    int $correctGcd,
    int $answer,
    bool $isCorrect
): void {
    $stmt = $pdo->prepare(
        'INSERT INTO rounds(played_at, player_name, a, b, correct_gcd, answer, is_correct)
         VALUES(:played_at, :player_name, :a, :b, :correct_gcd, :answer, :is_correct)'
    );

    $stmt->execute([
        ':played_at' => $playedAt,
        ':player_name' => $playerName,
        ':a' => $a,
        ':b' => $b,
        ':correct_gcd' => $correctGcd,
        ':answer' => $answer,
        ':is_correct' => $isCorrect ? 1 : 0,
    ]);
}

function fetchHistory(PDO $pdo, int $limit = 50): array
{
    $stmt = $pdo->prepare(
        'SELECT played_at, player_name, a, b, answer, is_correct
         FROM rounds
         ORDER BY id DESC
         LIMIT :limit'
    );
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}