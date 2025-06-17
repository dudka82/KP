<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <link rel="stylesheet" href="/css/style.css">
    <title>Личный кабинет</title>
</head>
<style>
button{
border-radius:6px;
text-align: center;
color:#F959C1;
background-color: #fff;
margin: auto;
border:0;
height: 30px;
width: 100px;
margin-top: 25px;margin-bottom: 150px; 
}
.admin-links {
margin: 15px 0;
padding: 10px;
    border-radius: 5px;
}
.admin-links{
    display: flex;
    justify-content: center;
}
.admin-link {
    display: inline-block;
    margin-right: 15px;
    padding: 8px 12px;
    background: #fff;
    color: #F959C1;
    border-radius: 4px;
    text-decoration: none;
    transition-duration: 0,5s;
}

.admin-link:hover {
    background: #F959C1;
    color: white;
}

.admin-link i {
    margin-right: 5px;
}
main{
            display:flex;
            justify-content: center;
            gap:130px;
}
.UF, .UC{
            background-color: #0E0E0E;
            border-radius:6px;
}
.UAI{
            width: 692px;height: 326px;
            background-color: #0E0E0E;
            border-radius:6px;
}
</style>
<body>
    <nav>
        <img src="images/logo.png" alt="logo" class="logo">
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
    <div class="fav">
        @auth
    @if(auth()->user()->role === 'admin')
        <div class="admin-links">
            <a href="{{ route('recipes.index') }}" class="admin-link">
                <i class="fas fa-list"></i> Модерация рецептов
            </a>
            <a href="{{ route('categories.index') }}" class="admin-link">
                <i class="fas fa-users"></i> Модерация категорий
            </a>
        </div>
    @endif
@endauth
    </div>
    <main>
        <div class="User-favCreate">
            <div class="User-fav">
                <h1>Список избранных рецептов</h1>
                <div class="UF"></div>

            </div>
            <div class="User-create">
                <h1>Список созданных рецептов</h1>
                <div class="UC"></div>
            </div>
        </div>
        <div class="User-accountInfo">
            <h1>Информация об аккаунте</h1>
            <div class="UAI"></div>
        </div>
    </main>
        <footer>
<img src="images/logo.png" alt="logo" class="logo">
<div class="SubInfo">
    <div class="Finfo">
        <h1>Навигация</h1>
           <ul>
            <li><a href="/">Главная</a></li>  
            <li><a href="{{ route('dashboard') }}">Личный кабинет</a></li>
            <li><a href="#">Избранное</a></li>
            </ul>
    </div>
    <div class="Finfo">
        <h1>Навигация</h1>
           <ul>
            <li><a href="{{ route('search') }}">Поиск</a></li>
            <li><a href="#">Лучшее</a></li>
            <li><a href="#">Добавить рецепт</a></li>
            </ul>
    </div>
</div>
    </footer>
</body>
</html>
