<p><a href="/">Главная</a></p>

<?php if ($rows === []): ?>
  <p>История пуста.</p>
<?php else: ?>
  <table border="1" cellpadding="6" class="table">
    <thead>
      <tr>
        <th>Время</th>
        <th>Игрок</th>
        <th>Числа</th>
        <th>Ответ</th>
        <th>Верно/неверно</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
      <tr>
        <td><?= htmlspecialchars((string)$r['played_at']) ?></td>
        <td><?= htmlspecialchars((string)$r['player_name']) ?></td>
        <td><?= (int)$r['a'] ?>, <?= (int)$r['b'] ?></td>
        <td><?= (int)$r['answer'] ?></td>
        <td><?= ((int)$r['is_correct'] === 1) ? 'верно' : 'неверно' ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>