<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/style.css">
    <title>Поиск</title>
</head>
<style>
    h1 {
        font-size: 24px;
        text-align: center;
        font-weight: normal;
    }
    h2{
        font-size: 24px;
        font-weight: normal;
        margin-bottom: 40px;
    }
    p{
        margin: 0;
        margin-bottom: 30px;
    }
    button{
        width: 150px;
        float:right;
        margin: 0;margin-top: 40px;
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
<main>
    <div class="SB">
        <input type="text" class="searchBar" placeholder="Поиск" id="searchInput">
    </div>
    
    <div class="sort">
        <div class="sortBy">
            <h2>Выбор по категориям</h2>
            <div class="SortByCat">
                <div class="category-list">
                    <div class="form-check">
                        <input class="form-check-input category-checkbox" type="checkbox" value="" id="allCategories" checked>
                        <label class="form-check-label" for="allCategories">
                            Все категории
                        </label>
                    </div>
                    @foreach($categories as $category)
                    <div class="form-check">
                        <input class="form-check-input category-checkbox" type="checkbox" value="{{ $category->id }}" id="category{{ $category->id }}">
                        <label class="form-check-label" for="category{{ $category->id }}">
                            {{ $category->title }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>

            <h2>Выбор по ключевым ингредиентам</h2>
            <div class="SortByIng">
                <div class="ingredient-list">
                    <div class="form-check">
                        <input class="form-check-input ingredient-checkbox" type="checkbox" value="" id="allIngredients" checked>
                        <label class="form-check-label" for="allIngredients">
                            Все ингредиенты
                        </label>
                    </div>
                    @foreach($ingredients as $ingredient)
                    <div class="form-check">
                        <input class="form-check-input ingredient-checkbox" type="checkbox" value="{{ $ingredient->id }}" id="ingredient{{ $ingredient->id }}">
                        <label class="form-check-label" for="ingredient{{ $ingredient->id }}">
                            {{ $ingredient->name }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mbCreate">
            <h2>Желаете стать частью нас</h2>
            <p>Добавьте свой рецепт и порадуйте сотни пользователей своим кулинарным шедевром</p>
            <p>Получите шанс попасть на страницу лучших рецептов</p>
            <p>Оставляйте комментарии и оценки рецептам чтобы продвигать рецепты</p>
            <button onclick="window.location.href='/recipes/create'">Создать рецепт</button>
        </div>
    </div>
    
    <div class="recipes_list">
        <h1>Все совпадения</h1>
        <div class="container mt-4" style="margin-top:50px">
            <div class="row" id="recipesContainer">
                @foreach($recipes as $recipe)
                <div class="col-md-4 mb-4 recipe-card" 
                     data-id="{{ $recipe->id }}"
                     data-title="{{ strtolower($recipe->title) }}"
                     data-image="{{ $recipe->image_url }}"
                     data-description="{{ strtolower($recipe->description) }}"
                     data-time="{{ $recipe->cooking_time }}"
                     data-difficulty="{{ $recipe->difficulty }}"
                     data-servings="{{ $recipe->servings }}"
                     data-category="{{ $recipe->category_id }}"
                     data-ingredients="{{ $recipe->ingredients->pluck('id')->implode(',') }}">
                    <div class="card h-100">
                        @if($recipe->image_url)
                            <img src="{{ asset($recipe->image_url) }}" class="card-img-top" alt="{{ $recipe->title }}">
                        @else
                            <img src="{{ asset('images/default.webp') }}" class="card-img-top" alt="Default image">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $recipe->title }}</h5>
                            <p class="card-text">{{ $recipe->cooking_time }} мин / {{ $recipe->difficulty }}</p>
                            <div class="recipe-meta">
                                <span class="badge bg-primary">{{ $recipe->category->name }}</span>
                                @foreach($recipe->ingredients->take(3) as $ingredient)
                                    <span class="badge bg-secondary">{{ $ingredient->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Получаем все необходимые элементы
    const searchInput = document.getElementById('searchInput');
    const allCategoriesCheckbox = document.getElementById('allCategories');
    const categoryCheckboxes = document.querySelectorAll('.category-checkbox:not(#allCategories)');
    const allIngredientsCheckbox = document.getElementById('allIngredients');
    const ingredientCheckboxes = document.querySelectorAll('.ingredient-checkbox:not(#allIngredients)');
    const recipeCards = document.querySelectorAll('.recipe-card');

    // Обработка чекбоксов категорий
    allCategoriesCheckbox.addEventListener('change', function() {
        categoryCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        filterRecipes();
    });
    
    categoryCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                allCategoriesCheckbox.checked = false;
            }
            filterRecipes();
        });
    });
    
    // Обработка чекбоксов ингредиентов
    allIngredientsCheckbox.addEventListener('change', function() {
        ingredientCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        filterRecipes();
    });
    
    ingredientCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                allIngredientsCheckbox.checked = false;
            }
            filterRecipes();
        });
    });

    // Обработка поисковой строки
    searchInput.addEventListener('input', filterRecipes);

    // Функция фильтрации
    function filterRecipes() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedCategories = Array.from(document.querySelectorAll('.category-checkbox:checked:not(#allCategories)'))
            .map(checkbox => checkbox.value);
        const selectedIngredients = Array.from(document.querySelectorAll('.ingredient-checkbox:checked:not(#allIngredients)'))
            .map(checkbox => checkbox.value);
        
        recipeCards.forEach(card => {
            const title = card.dataset.title.toLowerCase();
            const description = card.dataset.description.toLowerCase();
            const category = card.dataset.category;
            const ingredients = card.dataset.ingredients.split(',');
            
            // Проверяем соответствие всем критериям
            const matchesSearch = !searchTerm || 
                               title.includes(searchTerm) || 
                               description.includes(searchTerm);
            
            const matchesCategory = selectedCategories.length === 0 || 
                                 selectedCategories.includes(category);
            
            const matchesIngredient = selectedIngredients.length === 0 || 
                                    selectedIngredients.some(ing => ingredients.includes(ing));
            
            // Показываем/скрываем карточку в зависимости от соответствия фильтрам
            card.style.display = (matchesSearch && matchesCategory && matchesIngredient) ? 
                               'block' : 'none';
        });
    }

    // Инициализируем фильтрацию при загрузке
    filterRecipes();
    });
</script>
</body>
</html>