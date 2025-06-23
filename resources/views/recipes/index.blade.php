<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/style.css">
    <title>Управление рецептами</title>
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
        border-radius:6px;
    }
    .list-group-item {
                    background-color: #252525;
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
        .recipe-block {
        cursor: pointer;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }

    .recipe-block:hover {
        background-color: #f5f5f5;
        color: #000;
    }

    .recipe-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #000;
        z-index: 1000;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .overlay-content {
        background-color: #030303;
        padding: 30px;
        border-radius: 10px;
        max-width: 800px;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
    }
    
    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 24px;
        background: none;
        border: none;
        cursor: pointer;
    }
    
    .recipe-image {
        max-width: 100%;
        height: auto;
        margin-bottom: 20px;
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
    <h2>Управление рецептами</h2>
    
    <!-- Секция рецептов на модерации -->
    <div class="card mb-4">
        <div class="card-header bg-warning">
            <h1>Ожидающие модерации</h1>
        </div>
        <div class="card-body">
            @if($pendingRecipes->isEmpty())
                <p>Нет рецептов, ожидающих модерации.</p>
            @else
                <div class="list-group">
                    @foreach($pendingRecipes as $recipe)
                    <!-- Элемент рецепта -->
                    <div class="list-group-item">
                        <!-- Кликабельный блок рецепта -->
                        <div class="recipe-block" data-recipe-id="{{ $recipe->id }}" 
                             style="cursor: pointer; margin-bottom: 15px; padding: 10px; border: 1px solid #eee; border-radius: 5px;">
                            <div class="recipe-content">
                                <h5>{{ $recipe->title }}</h5>
                                <p class="mb-1">{{ Str::limit($recipe->description, 100) }}</p>
                                <small>
                                    Категория: {{ $recipe->category->title }}, 
                                    Время: {{ $recipe->cooking_time }} мин,
                                    Сложность: {{ $recipe->difficulty }},
                                    Порции: {{ $recipe->servings }}
                                </small>
                            </div>
                        </div>

                        <!-- Кнопки модерации -->
                        <div class="mt-2" style="height:70px">
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

                    <!-- Оверлей с деталями рецепта -->
                    <div class="recipe-overlay" id="overlay-{{ $recipe->id }}" 
                         style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
                         background-color: rgba(0,0,0,0.8); z-index: 1000; justify-content: center; align-items: center;">
                        <div class="overlay-content" 
                             style="background: #000; padding: 25px; border-radius: 8px; max-width: 1000px; 
                             max-height: 90vh; overflow-y: auto; position: relative;">
                            <button class="close-btn" 
                                    style="position: absolute; top: 10px; right: 10px; font-size: 24px; 
                                    background: none; border: none; cursor: pointer;">&times;</button>
                            
                            <h2>{{ $recipe->title }}</h2>
                            
                            <!-- Изображение рецепта -->
                            @if($recipe->image_url)
                                <img src="{{ asset($recipe->image_url) }}" alt="{{ $recipe->title }}" 
                                     style="max-width: 100%; height: auto; margin-bottom: 15px;">
                            @else
                                <img src="{{ asset('images/default.webp') }}" class="card-img-top" alt="Default image">
                            @endif
                            
                            <!-- Мета-информация -->
                            <div class="recipe-meta" style="margin-bottom: 15px;">
                                <p><strong>Категория:</strong> {{ $recipe->category->title }}</p>
                                <p><strong>Время приготовления:</strong> {{ $recipe->cooking_time }} минут</p>
                                <p><strong>Сложность:</strong> {{ $recipe->difficulty }}</p>
                                <p><strong>Порции:</strong> {{ $recipe->servings }}</p>
                            </div>
                            
                            <!-- Описание рецепта -->
                            <div class="recipe-description" style="margin-bottom: 15px;">
                                <h4>Описание</h4>
                                <p>{{ $recipe->description }}</p>
                            </div>
                            
                            <!-- Ингредиенты -->
                            @if($recipe->ingredients->isNotEmpty())
                            <div class="recipe-ingredients" style="margin-bottom: 15px;">
                                <h4>Ингредиенты</h4>
                                <ul>
                                    @foreach($recipe->ingredients as $ingredient)
                                        <li>{{ $ingredient->name }} - {{ $ingredient->pivot->amount }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            
                            <!-- Шаги приготовления -->
                            @if($recipe->steps->isNotEmpty())
                            <div class="recipe-steps">
                                <h4>Шаги приготовления</h4>
                                <ol>
                                    @foreach($recipe->steps as $step)
                                        <li>{{ $step->description }}</li><br>
                                        @if($step->image_url)
                                        <div class="step-image-container" style="width: 200px; height: 150px;">
                                            <img src="{{ asset($step->image_url) }}" 
                                                 style="width: 100%; height: 100%; object-fit: cover;">
                                        </div><br>
                                        @endif
                                    @endforeach
                                </ol>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Секция одобренных рецептов -->
    <div class="card">
        <div class="card-header bg-success">
            <h1>Одобренные рецепты</h1>
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
                            <!-- Форма удаления рецепта -->
                            <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" 
                                  onsubmit="return confirmDelete(event, '{{ $recipe->title }}');">
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

<script>
    function confirmDelete(event, title) {
        if (!confirm('Вы уверены, что хотите удалить рецепт "' + title + '"?')) {
            event.preventDefault();
            return false;
        }
        return true;
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Открытие оверлея при клике на рецепт
        document.querySelectorAll('.recipe-block').forEach(block => {
            block.addEventListener('click', function(e) {
                // Проверяем, не был ли клик по кнопке модерации
                if (!e.target.closest('form')) {
                    const recipeId = this.getAttribute('data-recipe-id');
                    document.getElementById(`overlay-${recipeId}`).style.display = 'flex';
                }
            });
        });

        // Закрытие оверлея
        document.querySelectorAll('.close-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                this.closest('.recipe-overlay').style.display = 'none';
            });
        });

        // Закрытие при клике вне контента
        document.querySelectorAll('.recipe-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.style.display = 'none';
                }
            });
        });
    });
</script>
</body>
</html>