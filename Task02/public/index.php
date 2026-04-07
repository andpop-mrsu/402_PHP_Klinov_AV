<?php

declare(strict_types=1);

session_start();

$title = 'GCD — Task02';
$playerName = $_SESSION['player_name'] ?? '';

$view = __DIR__ . '/../templates/home.php';
include __DIR__ . '/../templates/layout.php';