<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/style.css">
    <title>Добавить категорию</title>
<style>
    h1 {
        font-size: 20px;
        margin-left: 130px;margin-bottom: 100px;
        font-weight: normal;
    }

    .container {
        padding: 20px;
    }
    .card {
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .card-body {
        background-color: #252525;
        padding: 30px 100px;
        box-sizing:border-box;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-control {
        display: block;
        width: 100%;
        padding: 8px 12px;
        font-size: 16px;
        line-height: 1.5;
        color: #fff;
        background-color: #030303;
        background-clip: padding-box;
        border: none;
        border-radius: 4px;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    .form-control:focus {
        border-color: #F959C1;

        outline: 0;
        box-shadow: 0 0 0 0.2rem #F959C1;
    }
    .is-invalid {
        border-color: #dc3545;
    }
    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 5px;
        font-size: 80%;
        color: #dc3545;
    }
    .btn {
        display: inline-block;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        user-select: none;
        border: 1px solid transparent;
        padding: 4px 16px;
        font-size: 16px;
        width: 200px;
        line-height: 1.5;
        border-radius: 4px;
        margin-bottom: 10px;
        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    .btn-primary {
        color: #F959C1;
        background-color: #fff;
        border: none;
        width: 250px;
    }
    .btn-primary:hover {
        color:#fff ;
        background-color:#F959C1 ;
    }
    .col-md-8 {
        flex: 0 0 66.666667%;
        max-width: 66.666667%;
    }
    .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }
    .col-md-4 {
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
    }
    .justify-content-center {
        justify-content: center;
    }
    .text-md-right {
        text-align: left;
    }
    .offset-md-4 {
        margin-left: 33.333333%;
    }
    .mb-0 {
        margin-bottom: 0;
    }
    textarea.form-control {
        min-height: 100px;
    }
    select{
        background-color: #030303;
        color:#fff;
    }
    option{
        background-color: #252525;
    }
    option:hover{
        background-color: #030303;
    }
</style>
</head>
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
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h1>Создание категории</h1>

                <div class="card-body">
                    <form method="POST" action="{{ route('categories.store') }}">
                        @csrf               
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">Название категории</label>
                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Отправить на модерацию
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
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