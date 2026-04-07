<?php

declare(strict_types=1);

if (PHP_SAPI === 'cli-server') {
    $url = parse_url((string)($_SERVER['REQUEST_URI'] ?? '/'));
    $path = (string)($url['path'] ?? '/');
    $file = __DIR__ . $path;
    if ($path !== '/' && is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

use function NevallvonGoodem\Task03\Db\pdo;
use function NevallvonGoodem\Task03\Gcd\gcd;

ini_set('display_errors', '0');

$app = AppFactory::create();
$app->addBodyParsingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(false, false, false);

function jsonResponse(Response $response, mixed $data, int $status = 200): Response
{
    $json = json_encode($data, JSON_UNESCAPED_UNICODE);

    if ($json === false) {
        $json = '{}';
    }

    $response->getBody()->write($json);

    return $response
        ->withHeader('Content-Type', 'application/json; charset=utf-8')
        ->withStatus($status);
}

function readJson(Request $request): array
{
    $parsed = $request->getParsedBody();
    return is_array($parsed) ? $parsed : [];
}

// Serve SPA on /
$app->get('/', function (Request $request, Response $response): Response {
    $path = __DIR__ . '/index.html';
    $html = is_file($path) ? (string)file_get_contents($path) : '<h1>index.html not found</h1>';
    $response->getBody()->write($html);
    return $response->withHeader('Content-Type', 'text/html; charset=utf-8');
});

/**
 * GET /games
 */
$app->get('/games', function (Request $request, Response $response): Response {
    $db = pdo();

    $sql = '
        SELECT
            g.id,
            g.player_name,
            g.started_at,
            (SELECT COUNT(*) FROM steps s WHERE s.game_id = g.id) AS steps_count,
            COALESCE((SELECT SUM(s.is_correct) FROM steps s WHERE s.game_id = g.id), 0) AS correct_count
        FROM games g
        ORDER BY g.id DESC
    ';

    $rows = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    return jsonResponse($response, $rows);
});

/**
 * GET /games/{id}
 */
$app->get('/games/{id}', function (Request $request, Response $response, array $args): Response {
    $gameId = (int)($args['id'] ?? 0);
    if ($gameId <= 0) {
        return jsonResponse($response, ['error' => 'Invalid game id'], 400);
    }

    $db = pdo();

    $stmt = $db->prepare(
        'SELECT created_at, a, b, answer, correct_gcd, is_correct
         FROM steps
         WHERE game_id = :id
         ORDER BY id ASC'
    );
    $stmt->execute([':id' => $gameId]);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return jsonResponse($response, $rows);
});

/**
 * POST /games — create game
 * Body JSON: { "player_name": "..." }
 * Response JSON: { "id": 123 }
 */
$app->post('/games', function (Request $request, Response $response): Response {
    $data = readJson($request);
    $name = trim((string)($data['player_name'] ?? ''));

    if ($name === '') {
        return jsonResponse($response, ['error' => 'player_name is required'], 400);
    }

    $db = pdo();
    $startedAt = (new DateTimeImmutable())->format('Y-m-d H:i:s');

    $stmt = $db->prepare('INSERT INTO games(player_name, started_at) VALUES(:name, :started_at)');
    $stmt->execute([':name' => $name, ':started_at' => $startedAt]);

    return jsonResponse($response, ['id' => (int)$db->lastInsertId()], 201);
});

/**
 * POST /step/{id} — save step for game
 * Body JSON: { "a": 12, "b": 18, "answer": 6 }
 * Response JSON: { "is_correct": true/false, "correct_gcd": 6 }
 */
$app->post('/step/{id}', function (Request $request, Response $response, array $args): Response {
    $gameId = (int)($args['id'] ?? 0);
    if ($gameId <= 0) {
        return jsonResponse($response, ['error' => 'Invalid game id'], 400);
    }

    $data = readJson($request);

    $a = isset($data['a']) ? (int)$data['a'] : 0;
    $b = isset($data['b']) ? (int)$data['b'] : 0;
    $answer = isset($data['answer']) ? (int)$data['answer'] : 0;

    if ($a === 0 || $b === 0) {
        return jsonResponse($response, ['error' => 'a and b are required'], 400);
    }

    $correct = gcd($a, $b);
    $isCorrect = ($answer === $correct);

    $db = pdo();
    $createdAt = (new DateTimeImmutable())->format('Y-m-d H:i:s');

    $stmt = $db->prepare(
        'INSERT INTO steps(game_id, created_at, a, b, correct_gcd, answer, is_correct)
         VALUES(:game_id, :created_at, :a, :b, :correct_gcd, :answer, :is_correct)'
    );
    $stmt->execute([
        ':game_id' => $gameId,
        ':created_at' => $createdAt,
        ':a' => $a,
        ':b' => $b,
        ':correct_gcd' => $correct,
        ':answer' => $answer,
        ':is_correct' => $isCorrect ? 1 : 0,
    ]);

    return jsonResponse($response, ['is_correct' => $isCorrect, 'correct_gcd' => $correct], 201);
});

$app->run();
