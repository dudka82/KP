<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/style.css">
    <title>Главная</title>
<style>
    h1 {
        font-size: 24px;
        font-weight: normal;
        text-align: center;
        margin: auto;        
    } 
</style>
</head>
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
<main>
        <div class="info">
            <h3>Откройте для себя мир удивительных рецептов</h3>
            <h4>Множество рецептов уже ждут вас</h4>
            <h4>Посмотрите лучшие рецепты, отобранные людьми</h4>
            <button onclick="document.location='/best'">Смотреть</button>
        </div>
        <div class="recipes_list">
            <h1>Все рецепты</h1>
                <div class="container mt-4" style="margin-top:50px">
                    @if($recipes->isEmpty())
                    <p style="text-align: center;">На данный момент нет подходящих рецептов.</p>
                    @else
                    <div class="row" id="recipesContainer">
                        @foreach($recipes->where('status', 'approved') as $recipe)
                        <div class="col-md-4 mb-4 recipe-card" 
                            data-id="{{ $recipe->id }}"
                            data-title="{{ htmlspecialchars($recipe->title) }}"
                            data-image="{{ $recipe->image_url }}"
                            data-description="{{ htmlspecialchars($recipe->description) }}"
                            data-time="{{ $recipe->cooking_time }}"
                            data-difficulty="{{ $recipe->difficulty }}"
                            data-servings="{{ $recipe->servings }}">
                        <div class="card h-100">
                        @if($recipe->image_url)
                            <img src="{{ asset($recipe->image_url) }}" class="card-img-top" alt="{{ $recipe->title }}">
                        @else
                            <img src="{{ asset('images/default.webp') }}" class="card-img-top" alt="Default image">
                        @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ htmlspecialchars($recipe->title) }}</h5>
                                    <p class="card-text">{{ $recipe->cooking_time }} мин / {{ $recipe->difficulty }}</p>
                                </div>
                    </div>
                </div>
                        @endforeach
                    @endif
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
    <!-- Оверлей с деталями рецепта -->
<div class="recipe-overlay" id="recipeOverlay">
        <div class="recipe-detail">
            <button class="close-btn" id="closeBtn" style="color:#fff;">×</button>
            <img id="detailImage" src="" alt="" class="img-fluid mb-3">
            <h2 id="detailTitle"></h2>
            <p id="detailDescription"></p>
            <div class="recipe-meta mb-3">
                <p><strong>Время приготовления:</strong> <span id="detailTime"></span> минут</p>
                <p><strong>Сложность:</strong> <span id="detailDifficulty"></span></p>
                <p><strong>Порции:</strong> <span id="detailServings"></span></p>
            </div>
            <div class="recipe-actions">
                <a href="#" id="viewFullRecipe" class="btn btn-primary">
                    <i class="bi bi-file-text"></i> Полный рецепт
                </a> 
                <form id="favoriteForm" method="POST" action="/favorites">
                    <?= csrf_field() ?>
                    <input type="hidden" name="recipe_id" id="favoriteRecipeId" value="">
                </form>
            </div>
        </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
        // Ожидаем полной загрузки DOM
        document.addEventListener('DOMContentLoaded', function() {
            let currentRecipeId = null;
            const overlay = document.getElementById('recipeOverlay');
            const closeBtn = document.getElementById('closeBtn');
            const viewFullRecipe = document.getElementById('viewFullRecipe');
            const favoriteForm = document.getElementById('favoriteForm');
            
            // Проверяем существование элементов
            if (!overlay || !closeBtn || !viewFullRecipe || !favoriteForm) {
                console.error('Не найдены необходимые элементы DOM');
                return;
            }
            
            // Обработчики для карточек рецептов
            document.querySelectorAll('.recipe-card').forEach(card => {
                card.addEventListener('click', function() {
                    currentRecipeId = this.dataset.id;
                    
                    // Заполняем данные в оверлее
                    document.getElementById('detailImage').src = this.dataset.image || '<?= asset('images/default.webp') ?>';
                    document.getElementById('detailTitle').textContent = this.dataset.title;
                    document.getElementById('detailDescription').textContent = this.dataset.description;
                    document.getElementById('detailTime').textContent = this.dataset.time;
                    document.getElementById('detailDifficulty').textContent = this.dataset.difficulty;
                    document.getElementById('detailServings').textContent = this.dataset.servings;
                    
                    // Обновляем ссылку и форму
                    viewFullRecipe.href = `/recipes/${currentRecipeId}`;
                    document.getElementById('favoriteRecipeId').value = currentRecipeId;
                    
                    // Показываем оверлей
                    overlay.style.display = 'flex';
                });
            });
            
            // Закрытие оверлея
            closeBtn.addEventListener('click', function() {
                overlay.style.display = 'none';
            });
            
            // Закрытие по клику вне области
            overlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    overlay.style.display = 'none';
                }
            });
        });
</script>   
</body>
</html>

