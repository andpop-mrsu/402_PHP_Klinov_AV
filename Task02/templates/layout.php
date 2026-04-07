<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title) ?></title>
  <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
  <div class="container">
    <div class="header">
      <h1 class="brand"><?= htmlspecialchars($title) ?></h1>
      <nav class="nav">
        <a href="/">Главная</a>
        <a href="/play.php">Играть</a>
        <a href="/history.php">История</a>
      </nav>
    </div>

    <div class="card">
      <?php include $view; ?>
    </div>
  </div>
</body>
</html>