<?php if (!empty($playerName)): ?>
  <p><span class="badge">Текущий игрок: <?= htmlspecialchars($playerName) ?></span></p>
  <div class="form-row">
    <a class="btn" href="/play.php">Играть</a>
    <a class="btn btn-secondary" href="/history.php">История</a>
    <a class="btn btn-secondary" href="/reset.php">Сбросить имя</a>
  </div>
<?php else: ?>
  <p class="muted">Введите имя, чтобы начать игру.</p>
  <form method="post" action="/play.php" class="stack">
    <div>
      <label for="player_name">Имя</label>
      <input id="player_name" class="input" type="text" name="player_name" required>
    </div>
    <button class="btn" type="submit">Начать игру</button>
  </form>
<?php endif; ?>