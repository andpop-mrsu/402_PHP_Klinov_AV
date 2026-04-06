<?php

declare(strict_types=1);

session_start();
unset($_SESSION['player_name']);

header('Location: /');
exit;