# GCD Game (Наибольший общий делитель)

Игра на PHP: по двум случайным целым числам нужно вычислить **НОД** и ввести его в терминале.

Проект выполнен в рамках дисциплины  
**«Технологии разработки серверных приложений на PHP»**.

## Описание

Single Page Application для игры «НОД» (GCD), которая взаимодействует с backend-частью по REST API и сохраняет данные в SQLite.

Backend реализован на микрофреймворке Slim. Frontend обменивается данными с сервером в формате JSON через HTTP-запросы.

Маршруты REST API:
- `GET /games` — список игр
- `GET /games/{id}` — список ходов выбранной игры
- `POST /games` — создать новую игру (возвращает `id`)
- `POST /step/{id}` — записать ход игры (возвращает результат проверки)

## Требования

- PHP 8.0+
- Composer
- SQLite (PDO + pdo_sqlite)

## Установка

Из каталога `Task03`:

```bash
composer install
```

## Запуск

В задании сервер запускается на 3000 порту и корень — `public`. 

Для корректной маршрутизации Slim во встроенном веб‑сервере PHP используйте тот же `public/index.php` как router‑script:

```bash
php -S localhost:3000 -t public public/index.php
```

Открыть в браузере:
- http://localhost:3000/  (SPA)
- http://localhost:3000/index.html

## База данных

SQLite файл создаётся автоматически в каталоге:
- `Task03/db/gcd.sqlite`

Каталог `db` расположен вне `public`, как требует задание. 

## Структура проекта

```
Task03/
  public/
    index.php      # единственная PHP-точка входа (Slim)
    index.html     # SPA
    app.js
    styles.css
  src/
    Db.php
    Gcd.php
  db/
    gcd.sqlite     # создаётся автоматически
  composer.json
  README.md
```
## Автор

Nevall von Goodem  
GitHub: Nevall-von-Goodem