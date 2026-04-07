const $ = (id) => document.getElementById(id);

let gameId = null;
let a = 0;
let b = 0;

function rnd(min, max) {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

function newNumbers() {
  a = rnd(1, 100);
  b = rnd(1, 100);
  $("a").textContent = a;
  $("b").textContent = b;
  $("answer").value = "";
}

function showResult(text) {
  $("result").textContent = text;
}

async function api(path, opts = {}) {
  const res = await fetch(path, {
    headers: { "Content-Type": "application/json" },
    ...opts,
  });

  const data = await res.json().catch(() => ({}));
  if (!res.ok) {
    const msg = data && data.error ? data.error : "Request failed";
    throw new Error(msg);
  }
  return data;
}

$("tabPlay").onclick = () => {
  $("play").classList.remove("hidden");
  $("history").classList.add("hidden");
};

$("tabHistory").onclick = async () => {
  $("history").classList.remove("hidden");
  $("play").classList.add("hidden");
  await loadGames();
};

$("startGame").onclick = async () => {
  const name = $("playerName").value.trim();
  if (!name) {
    alert("Введите имя");
    return;
  }

  try {
    const created = await api("/games", {
      method: "POST",
      body: JSON.stringify({ player_name: name }),
    });

    gameId = created.id;
    $("gameArea").classList.remove("hidden");
    showResult("");
    newNumbers();
  } catch (e) {
    alert(e.message);
  }
};

$("sendStep").onclick = async () => {
  if (!gameId) {
    alert("Сначала нажмите «Начать»");
    return;
  }

  const answer = parseInt($("answer").value, 10);
  if (Number.isNaN(answer)) {
    alert("Введите число");
    return;
  }

  try {
    const r = await api(`/step/${gameId}`, {
      method: "POST",
      body: JSON.stringify({ a, b, answer }),
    });

    showResult(r.is_correct ? "Верно!" : `Неверно. Правильный ответ: ${r.correct_gcd}`);
    newNumbers();
  } catch (e) {
    alert(e.message);
  }
};

async function loadGames() {
  try {
    const games = await api("/games");
    $("games").innerHTML = renderGamesTable(games);

    document.querySelectorAll("[data-game-id]").forEach((btn) => {
      btn.onclick = async () => {
        const id = btn.getAttribute("data-game-id");
        const steps = await api(`/games/${id}`);
        $("steps").innerHTML = renderStepsTable(steps);
      };
    });

    $("steps").innerHTML = "<p class='muted'>Выберите игру.</p>";
  } catch (e) {
    $("games").innerHTML = `<p class="muted">Ошибка загрузки: ${escapeHtml(e.message)}</p>`;
  }
}

function renderGamesTable(rows) {
  if (!rows.length) return "<p class='muted'>Пока нет игр.</p>";

  const trs = rows
    .map(
      (r) => `
    <tr>
      <td>${r.id}</td>
      <td>${escapeHtml(r.player_name)}</td>
      <td>${escapeHtml(r.started_at)}</td>
      <td>${r.steps_count ?? 0}</td>
      <td>${r.correct_count ?? 0}</td>
      <td><button class="btn btn-secondary" type="button" data-game-id="${r.id}">Открыть</button></td>
    </tr>`
    )
    .join("");

  return `
  <table class="table">
    <thead>
      <tr>
        <th>ID</th><th>Игрок</th><th>Старт</th><th>Ходов</th><th>Верных</th><th></th>
      </tr>
    </thead>
    <tbody>${trs}</tbody>
  </table>`;
}

function renderStepsTable(rows) {
  if (!rows.length) return "<p class='muted'>Нет ходов.</p>";

  const trs = rows
    .map(
      (r) => `
    <tr>
      <td>${escapeHtml(r.created_at)}</td>
      <td>${r.a}, ${r.b}</td>
      <td>${r.answer}</td>
      <td>${r.is_correct ? "верно" : "неверно"}</td>
    </tr>`
    )
    .join("");

  return `
  <table class="table">
    <thead>
      <tr><th>Время</th><th>Числа</th><th>Ответ</th><th>Результат</th></tr>
    </thead>
    <tbody>${trs}</tbody>
  </table>`;
}

function escapeHtml(s) {
  return String(s ?? "").replace(/[&<>"']/g, (c) => ({
    "&": "&amp;",
    "<": "&lt;",
    ">": "&gt;",
    '"': "&quot;",
    "'": "&#039;",
  }[c]));
}
