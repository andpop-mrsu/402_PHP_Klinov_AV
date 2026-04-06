<?php if (empty($playerName)): ?>
  <p>Сначала введите имя игрока.</p>
  <p><a class="btn btn-secondary" href="/">На главную</a></p>
<?php else: ?>
  <p><span class="badge">Игрок: <?= htmlspecialchars($playerName) ?></span></p>

  <p>
    Найдите НОД чисел:
    <b><?= (int)$a ?></b> и <b><?= (int)$b ?></b>
  </p>

  <?php if ($result !== null): ?>
    <?php if ($result['is_correct']): ?>
      <p><span class="badge ok">Верно</span></p>
    <?php else: ?>
      <p><span class="badge bad">Неверно</span> Правильный ответ: <b><?= (int)$result['correct_gcd'] ?></b></p>
    <?php endif; ?>

    <div class="form-row">
      <a class="btn" href="/play.php">Сыграть ещё</a>
      <a class="btn btn-secondary" href="/history.php">История</a>
      <a class="btn btn-secondary" href="/">Главная</a>
    </div>
  <?php else: ?>
    <form method="post" action="/play.php" class="stack">
      <input type="hidden" name="a" value="<?= (int)$a ?>">
      <input type="hidden" name="b" value="<?= (int)$b ?>">

      <div>
        <label for="answer">Ваш ответ</label>
        <input id="answer" class="input" type="number" name="answer" required>
      </div>

      <button class="btn" type="submit">Ответить</button>
    </form>
  <?php endif; ?>
<?php endif; ?>