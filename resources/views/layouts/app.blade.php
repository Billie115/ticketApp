<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Help Tracker')</title>
    <link rel="stylesheet" href="https://unpkg.com/xp.css">
    <style>
        body {
            background: #3a6ea5;
            background: linear-gradient(#5a8ac9, #3a6ea5);
            min-height: 100vh;
            margin: 0;
            padding: 40px 20px;
            font-family: Tahoma, 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }
        .window {
            width: 100%;
            max-width: 600px;
        }
    </style>
</head>
<body>
    <div class="window">
        <div class="title-bar">
            <div class="title-bar-text">@yield('title', 'Help Tracker')</div>
            <div class="title-bar-controls">
                <button aria-label="Minimize"></button>
                <button aria-label="Maximize"></button>
                <button aria-label="Close"></button>
            </div>
        </div>
        <div class="window-body">
            @yield('content')
        </div>
    </div>
</body>
</html>