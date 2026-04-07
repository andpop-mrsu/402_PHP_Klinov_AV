<?php

declare(strict_types=1);

session_start();

require __DIR__ . '/../src/Gcd.php';
require __DIR__ . '/../src/Db.php';

use function NevallvonGoodem\Task02\Db\insertRound;
use function NevallvonGoodem\Task02\Db\pdo;
use function NevallvonGoodem\Task02\Gcd\gcd;
use function NevallvonGoodem\Task02\Gcd\makeNumbers;

$title = 'Игра: НОД';
$playerName = '';

if (isset($_POST['player_name'])) {
    $_SESSION['player_name'] = trim((string)$_POST['player_name']);
}

$playerName = (string)($_SESSION['player_name'] ?? '');

$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['a'], $_POST['b'], $_POST['answer']) && $playerName !== '') {
    $a = (int)$_POST['a'];
    $b = (int)$_POST['b'];
    $answer = (int)$_POST['answer'];

    $correct = gcd($a, $b);
    $isCorrect = ($answer === $correct);

    $playedAt = (new DateTimeImmutable())->format('Y-m-d H:i:s');
    $db = pdo();
    insertRound($db, $playedAt, $playerName, $a, $b, $correct, $answer, $isCorrect);

    $result = [
        'correct_gcd' => $correct,
        'is_correct' => $isCorrect,
    ];
} else {
    [$a, $b] = makeNumbers(1, 100);
}

$view = __DIR__ . '/../templates/play.php';
include __DIR__ . '/../templates/layout.php';