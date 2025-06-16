<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Управление рецептами</title>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .card {
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .card-header {
            padding: 15px 20px;
            font-weight: 600;
        }
        .bg-warning {
            background-color: #fff3cd;
        }
        .bg-success {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        .list-group-item {
            padding: 15px;
            border-left: none;
            border-right: none;
        }
        .list-group-item:first-child {
            border-top: none;
        }
        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }
        .badge {
            font-size: 14px;
            padding: 5px 10px;
        }
        h1, h2 {
            margin-bottom: 20px;
        }
        .d-flex {
            display: flex;
        }
        .justify-content-between {
            justify-content: space-between;
        }
        .align-items-center {
            align-items: center;
        }
        .mb-1 {
            margin-bottom: 5px;
        }
        .mb-4 {
            margin-bottom: 20px;
        }
        .d-inline {
            display: inline;
        }
        small {
            font-size: 12px;
            color: #6c757d;
        }

        nav {
            display: flex;
            justify-content: space-between;
            padding: 0 70px;
            border-bottom: 1px solid #000;
            align-items: center;
            height: 60px;
        }
        ul {
            display: flex;
            gap: 100px;
            list-style: none;
            padding: 0;
            margin: 0;
            align-items: center;
        }
        li {
            list-style: none;
        }
        a {
            text-decoration: none;
            color: #000;
            transition: color 0.3s;
        }
        a:hover {
            color:rgb(230, 142, 2);
        }
        .slider {
            width: 700px;
            height: 500px;
            background: #eee;
            margin: 20px auto;
        }
        h1 {
            font-size: 24px;
            margin-left: 200px;
            font-weight: normal;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
        }
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4b5563;
            font-weight: bold;
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 4px;
        }
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>
<body>
    <nav>
        <img src="" alt="logo">
        <ul>
            <li><a href="/">Главная</a></li>
            <li><a href="{{ route('search') }}">Поиск</a></li>
            <li><a href="">Лучшее</a></li>
        </ul>
        <ul>
            <li><a href="/categories/create">Добавить категорию</a></li>
            <li><a href="/recipes/create">Добавить рецепт</a></li>
            <li>
                @auth
                    <div class="dropdown">
                        <div class="user-info">
                            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                            <span>{{ Auth::user()->name }}</span>
                        </div>
                        <div class="dropdown-content">
                            <a href="{{ route('dashboard') }}">Личный кабинет</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" 
                                   onclick="event.preventDefault();
                                   this.closest('form').submit();">
                                   Выйти
                                </a>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}">Войти</a>
                @endauth
            </li>
        </ul>
    </nav>
    <div class="container">
        <h1>Управление рецептами</h1>
        
        <div class="card mb-4">
            <div class="card-header bg-warning">
                <h2>Ожидающие модерации</h2>
            </div>
            <div class="card-body">
                @if($pendingRecipes->isEmpty())
                    <p>Нет рецептов, ожидающих модерации.</p>
                @else
                    <div class="list-group">
                        @foreach($pendingRecipes as $recipe)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5>{{ $recipe->title }}</h5>
                                        <p class="mb-1">{{ Str::limit($recipe->description, 100) }}</p>
                                        <small>
                                            Категория: {{ $recipe->category->name }}, 
                                            Время: {{ $recipe->cooking_time }} мин,
                                            Сложность: {{ $recipe->difficulty }},
                                            Порции: {{ $recipe->servings }}
                                        </small>
                                    </div>
                                    <div>
                                        <form action="{{ route('recipes.approve', $recipe) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Одобрить</button>
                                        </form>
                                        <form action="{{ route('recipes.reject', $recipe) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Отклонить</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-success">
                <h2>Одобренные рецепты</h2>
            </div>
            <div class="card-body">
                @if($approvedRecipes->isEmpty())
                    <p>Нет одобренных рецептов.</p>
                @else
                    <div class="list-group">
                        @foreach($approvedRecipes as $recipe)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5>{{ $recipe->title }}</h5>
                                        <p class="mb-1">{{ Str::limit($recipe->description, 100) }}</p>
                                        <small>
                                            Категория: {{ $recipe->category->title }}, 
                                            Время: {{ $recipe->cooking_time }} мин,
                                            Сложность: {{ $recipe->difficulty }},
                                            Порции: {{ $recipe->servings }}
                                        </small>
                                    </div>
                                    <div>
                                        <span class="badge badge-success">Одобрен</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>