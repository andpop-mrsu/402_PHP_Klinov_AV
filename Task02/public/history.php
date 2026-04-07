<?php

declare(strict_types=1);

session_start();

require __DIR__ . '/../src/Db.php';

use function NevallvonGoodem\Task02\Db\fetchHistory;
use function NevallvonGoodem\Task02\Db\pdo;

$title = 'Прошлые партии';
$db = pdo();
$rows = fetchHistory($db, 50);

$view = __DIR__ . '/../templates/history.php';
include __DIR__ . '/../templates/layout.php';