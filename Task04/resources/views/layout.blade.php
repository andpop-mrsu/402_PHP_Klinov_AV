<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'GCD Game' }}</title>
    <style>
        :root {
            --bg: #f6f7f9;
            --card: #ffffff;
            --text: #111827;
            --muted: #6b7280;
            --border: #e5e7eb;
            --shadow: 0 1px 2px rgba(0,0,0,.06);
            --radius: 12px;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        .container {
            max-width: 860px;
            margin: 0 auto;
            padding: 24px 16px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .nav {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .nav a, .nav button {
            text-decoration: none;
            color: var(--text);
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 8px 12px;
            cursor: pointer;
            font-size: 14px;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 16px;
        }

        .input {
            width: 260px;
            max-width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 10px;
        }

        .btn {
            border: 1px solid #111827;
            background: #111827;
            color: #fff;
            padding: 10px 12px;
            border-radius: 10px;
            cursor: pointer;
        }

        .muted { color: var(--muted); }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            border: 1px solid var(--border);
            background: #fff;
        }

        .ok {
            background: #ecfdf5;
            border-color: #bbf7d0;
            color: #065f46;
        }

        .bad {
            background: #fef2f2;
            border-color: #fecaca;
            color: #991b1b;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid var(--border);
            background: #fff;
        }

        .table th, .table td {
            padding: 10px 12px;
            border-bottom: 1px solid var(--border);
            text-align: left;
        }

        .table th {
            background: #f3f4f6;
        }

        form.inline {
            display: inline;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>{{ $title ?? 'GCD Game' }}</h1>
        <div class="nav">
            <a href="/">Главная</a>
            <a href="/play">Играть</a>
            <a href="/history">История</a>
            <form class="inline" method="post" action="/reset">
                @csrf
                <button type="submit">Сбросить имя</button>
            </form>
        </div>
    </div>

    <div class="card">
        @yield('content')
    </div>
</div>
</body>
</html>