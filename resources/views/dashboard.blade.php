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
.UF, .UC {
    max-height: 300px;
    overflow-y: auto;
    border-radius: 6px;
    padding: 20px;
    margin-bottom: 20px;
    background-color: #0E0E0E;
}

.UF .list-group, .UC .list-group {
    list-style: none;
    padding: 0;
    margin: 0;
}

.UF .list-group li, .UC .list-group li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #eee;
}

.UF .list-group li:last-child , .UC .list-group li:last-child {
    border-bottom: none;
}

.UF .list-group a, .UC .list-group a {
    text-decoration: none;
    color: #fff;
    flex-grow: 1;
}
.UF .list-group a:hover, .UC .list-group a:hover {
    text-decoration: none;
    color: #F959C1;
    flex-grow: 1;
}
.UF .list-group button , .UC .list-group button{
    background-color: #fff;
    color: #F959C1;
    border: none;
    padding: 5px 10px;
    border-radius: 3px;
    cursor: pointer;
    margin-left: 10px;
}

.UF .list-group button:hover, .UC .list-group button:hover {
    background-color: #F959C1;
    color:#fff;
}

.UF p.empty-message, .UC p.empty-message {
    padding: 10px;
    color: #666;
    text-align: center;
}
.UAI{
            width: 692px;height: 326px;
            background-color: #0E0E0E;
            border-radius:6px;
}
main li{
    width: 293px;
    display:flex;
    justify-content: space-between;
    padding:0;
}
main li:last-child{
    padding-bottom:20px;
}
.list-group{
    display:flex;
    flex-direction:column;
    gap:10px;
}
.card-body{
    padding: 20px;
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
                <i ></i> Модерация рецептов
            </a>
            <a href="{{ route('categories.index') }}" class="admin-link">
                <i ></i> Модерация категорий
            </a>
        </div>
    @endif
@endauth
    </div>
    <main>
<div class="User-favCreate">
    <div class="User-fav">
        <h1>Список избранных рецептов</h1>
        <div class="UF">
            @if($favoriteRecipes->isEmpty())
                <p>У вас пока нет избранных рецептов</p>
            @else
                <ul class="list-group">
                    @foreach($favoriteRecipes as $recipe)
                        <li >
                            <a href="{{ route('recipes.show', $recipe->id) }}"> {{ Str::limit($recipe->title, 6) }}</a>
                            <form action="{{ route('favorites.destroy', $recipe->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="width:150px;font-size:12px" >Удалить из избранного</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    <div class="User-create">
        <h1>Список созданных рецептов</h1>
        <div class="UC">
            @if($createdRecipes->isEmpty())
                <p>Вы еще не создали ни одного рецепта</p>
            @else
                <ul class="list-group">
                    @foreach($createdRecipes as $recipe)
                        <li>
                            <a href="{{ route('recipes.show', $recipe->id) }}"> {{ Str::limit($recipe->title, 6) }}</a>
                            <div>
                                <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"  onclick="return confirm('Вы уверены, что хотите удалить этот рецепт?')">Удалить</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
<div class="User-accountInfo">
    <h1>Информация об аккаунте</h1>
    <div class="UAI">
        <div class="card">
            <div class="card-body">
                <p><strong>Имя:</strong> {{ Auth::user()->name }}</p>
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                <p><strong>Дата регистрации:</strong> {{ Auth::user()->created_at->format('d.m.Y') }}</p>
                <p><strong>Всего оставленных оценок:</strong> {{ $ratingsCount }}</p>
                <p><strong>Всего оставленных комментариев:</strong> {{ $commentsCount }}</p>
                <p><strong>Всего добавленных в избранное:</strong> {{ $favoriteRecipes->count() }}</p>
                <p><strong>Всего созданных рецептов:</strong> {{ $createdRecipes->count() }}</p>
            </div>
        </div>
    </div>
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
