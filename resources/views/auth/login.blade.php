<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <title>Вход</title>
</head>
<style>
    main{
        min-height: 100%;
        min-width: 100%;
    }
    .container{
        padding-top: 30px;
        box-sizing:border-box;
        width: 400px;height: 300px;
        border-radius:6px;
        background-color: #0E0E0E;
        margin: auto;
        margin-top: 280px;
        text-align: center;
    }
    h1 {
        text-align: center;
        color: #fff;
    }
    label {
        display: block;
        margin: 5px 0;
        font-size: 14px;
        color: #fff;
        text-align: left;
        margin-left: 90px;
    }
    
    input {
        width: 220px;
        padding: 6px;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        box-sizing: border-box;
        background-color: #030303 !important;
        color:#fff;
    }
    
    input:focus {
        background-color: #030303;
        outline: none;
    }
    input:-webkit-autofill{
        background-color: #030303;   
    }
    .buttons {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 30px;
        margin-left: 90px;
        gap:20px;
    }
    button{
        margin: 0;
    }
</style>
<body>
<nav>
    <img src="/images/logo.png" alt="logo" class="logo">
    <ul>
        <li><a href="/">Главная</a></li>
        <li><a href="/favorite">Избранное</a></li>
        <li><a href="{{ route('search') }}">Поиск</a></li>
        <li><a href="/best">Лучшее</a></li>
    </ul>
    <ul>
        <li><a href="/recipes/create">Добавить рецепт</a></li>
        <li>
            @auth
                <div class="dropdown">
                    <div class="user-info">
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
<main>
    <div class="container">
        <h1>Войти</h1>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" autocomplete="off" required>
            </div>
            
            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password" autocomplete="off" required>
            </div>
            
            <div class="buttons">
                <a href="{{ route('register') }}">Регистрация</a>
                <button type="submit">Войти</button>
            </div>
        </form>
    </div>
</main>
<footer>
    <img src="/images/logo.png" alt="logo" class="logo">
    <div class="SubInfo">
        <div class="Finfo">
            <h1>Навигация</h1>
            <ul>
                <li><a href="/">Главная</a></li>  
                <li><a href="{{ route('dashboard') }}">Личный кабинет</a></li>
                <li><a href="/favorite">Избранное</a></li>
                </ul>
        </div>
        <div class="Finfo">
            <h1>Навигация</h1>
            <ul>
                <li><a href="{{ route('search') }}">Поиск</a></li>
                <li><a href="/best">Лучшее</a></li>
                <li><a href="/recipes/create">Добавить рецепт</a></li>
                </ul>
        </div>
    </div>
</footer>
</body>
</html>
