<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
                 <link rel="stylesheet" href="/css/style.css">
    <title>Управление категориями</title>
    <style>
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
        .card-body{
            background-color: #252525;
            border-radius:6px;
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
              <button onclick="document.location='/categories/create'" style="margin:10px;width:150px">Добавить категорию</button>  
        <h2>Управление категориями</h2>

        <div class="card mb-4">
            <div class="card-header bg-warning">
                <h1>Ожидающие модерации</h1>
            </div>
            <div class="card-body">
                @if($pendingCategories->isEmpty())
                    <p>Нет категгорий, ожидающих модерации.</p>
                @else
                    <div class="list-group">
                        @foreach($pendingCategories as $category)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-1">{{ $category->title }}</p>
                                    </div>
                                    <div>
                                        <form action="{{ route('categories.approve', $category) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Одобрить</button>
                                        </form>
                                        <form action="{{ route('categories.reject', $category) }}" method="POST" class="d-inline">
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
                <h1>Одобренные категории</h1>
            </div>
            <div class="card-body">
                @if($approvedCategories->isEmpty())
                    <p>Нет одобренных категорий.</p>
                @else
                    <div class="list-group">
                        @foreach($approvedCategories as $category)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-1">{{ $category->title }}</p>
                                    </div>
<form action="{{ route('categories.destroy', $category) }}" method="POST" 
      onsubmit="return confirmDelete(event, '{{ $category->title }}');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
</form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
         <footer style="margin-top: 180px;">
<img src="/images/logo.png" alt="logo" class="logo">
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
    <script>
function confirmDelete(event, title) {
    if (!confirm('Вы уверены, что хотите удалить категорию "' + title + '"?')) {
        event.preventDefault();
        return false;
    }
    return true;
}
</script>
</body>
</html>