<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/style.css">
    <title>Добавить рецепт</title>
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
                    <h1>Создание рецепта</h1>
                    <div class="card-body">
                        <form method="POST" action="{{ route('recipes.store') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="category_id" class="col-md-4 col-form-label text-md-right">Категория</label>
                                <div class="col-md-6">
                                   <select id="category_id" name="category_id" required>
        @foreach($categories->where('status', 'approved') as $category)
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">Название рецепта</label>
                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">Описание</label>
                                <div class="col-md-6">
                                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required rows="5">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="cooking_time" class="col-md-4 col-form-label text-md-right">Время приготовления (мин)</label>
                                <div class="col-md-6">
                                    <input id="cooking_time" type="number" min="1" class="form-control @error('cooking_time') is-invalid @enderror" name="cooking_time" value="{{ old('cooking_time') }}" required>
                                    @error('cooking_time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="difficulty" class="col-md-4 col-form-label text-md-right">Сложность</label>
                                <div class="col-md-6">
                                    <select id="difficulty" class="form-control @error('difficulty') is-invalid @enderror" name="difficulty" required>
                                        <option value="">Выберите сложность</option>
                                        <option value="easy" {{ old('difficulty') == 'easy' ? 'selected' : '' }}>Легко</option>
                                        <option value="medium" {{ old('difficulty') == 'medium' ? 'selected' : '' }}>Средне</option>
                                        <option value="hard" {{ old('difficulty') == 'hard' ? 'selected' : '' }}>Сложно</option>
                                    </select>
                                    @error('difficulty')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="servings" class="col-md-4 col-form-label text-md-right">Количество порций</label>
                                <div class="col-md-6">
                                    <input id="servings" type="number" min="1" class="form-control @error('servings') is-invalid @enderror" name="servings" value="{{ old('servings') }}" required>
                                    @error('servings')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="image_url" class="col-md-4 col-form-label text-md-right">URL изображения</label>
                                <div class="col-md-6">
                                    <input id="image_url" type="url" class="form-control @error('image_url') is-invalid @enderror" name="image_url" value="{{ old('image_url') }}">
                                    @error('image_url')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Секция ингредиентов -->
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Ингредиенты</span></label>
                                <div class="col-md-6">
                                    <div id="ingredients-container">
                                        @if(old('ingredients'))
                                            @foreach(old('ingredients') as $index => $ingredient)
                                                <div class="ingredient-group mb-2">
                                                    <div class="input-group">
                                                        <select name="ingredients[{{ $index }}][id]" class="form-control ingredient-select" required>
                                                            <option value="">Выберите ингредиент</option>
                                                            @foreach($allIngredients as $ing)
                                                                <option value="{{ $ing->id }}" {{ $ingredient['id'] == $ing->id ? 'selected' : '' }}>{{ $ing->name }}</option>
                                                            @endforeach
                                                        </select><br>
                                                        <input type="text" name="ingredients[{{ $index }}][amount]" class="form-control ingredient-amount" placeholder="Количество" value="{{ $ingredient['amount'] ?? '' }}" required>
                                                        <div class="input-group-append">

                                                        </div>
                                                    </div>
                                                    <div class="ingredient-error text-danger small" style="display: none;"></div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="ingredient-group mb-2">
                                                <div class="input-group">
                                                    <select name="ingredients[0][id]" class="form-control ingredient-select" required>
                                                        <option value="">Выберите ингредиент</option>
                                                        @foreach($allIngredients as $ingredient)
                                                            <option value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>
                                                        @endforeach
                                                    </select><br>
                                                    <input type="text" name="ingredients[0][amount]" class="form-control ingredient-amount" placeholder="Количество" required>
                                                    <div class="input-group-append">

                                                    </div>
                                                </div>
                                                <div class="ingredient-error text-danger small" style="display: none;"></div>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" id="add-ingredient" class="btn btn-secondary mt-2">Добавить ингредиент</button>
                                    <div id="ingredients-error" class="text-danger small" style="display: none;"></div>
                                    @error('ingredients')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Секция шагов приготовления -->
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Шаги приготовления</label>
                                <div class="col-md-6">
                                    <div id="steps-container">
                                        @if(old('steps'))
                                            @foreach(old('steps') as $index => $step)
                                                <div class="step-group mb-3">
                                                    <label>Шаг {{ $index + 1 }}</label>
                                                    <textarea name="steps[{{ $index }}][description]" class="form-control step-description" rows="2" required>{{ $step['description'] }}</textarea>
                                                    <div class="step-error text-danger small" style="display: none;"></div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="step-group mb-3">
                                                <label>Шаг 1</label>
                                                <textarea name="steps[0][description]" class="form-control step-description" rows="2" required></textarea>
                                                <div class="step-error text-danger small" style="display: none;"></div>

                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" id="add-step" class="btn btn-secondary mt-2">Добавить шаг</button>
                                    <div id="steps-error" class="text-danger small" style="display: none;"></div>
                                    @error('steps')
                                        <span class="invalid-feedback d-block" role="alert">
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
<!-- JavaScript для динамического добавления полей -->
   <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Добавление ингредиента
        document.getElementById('add-ingredient').addEventListener('click', function() {
            const container = document.getElementById('ingredients-container');
            const index = container.querySelectorAll('.ingredient-group').length;
            
            const div = document.createElement('div');
            div.className = 'ingredient-group mb-2';
            div.innerHTML = `
                <div class="input-group">
                    <select name="ingredients[${index}][id]" class="form-control ingredient-select" required>
                        <option value="">Выберите ингредиент</option>
                        @foreach($allIngredients as $ingredient)
                            <option value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>
                        @endforeach
                    </select><br>
                    <input type="text" name="ingredients[${index}][amount]" class="form-control ingredient-amount" placeholder="Количество" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-danger remove-ingredient" style="margin-bottom:5px">Удалить</button>
                    </div>
                </div>
                <div class="ingredient-error text-danger small" style="display: none;"></div>
            `;
            
            container.appendChild(div);
        });

        // Добавление шага
        document.getElementById('add-step').addEventListener('click', function() {
            const container = document.getElementById('steps-container');
            const index = container.querySelectorAll('.step-group').length;
            
            const div = document.createElement('div');
            div.className = 'step-group mb-3';
            div.innerHTML = `
                <label>Шаг ${index + 1}</label>
                <textarea name="steps[${index}][description]" class="form-control step-description" rows="2" required></textarea>
                <div class="step-error text-danger small" style="display: none;"></div>
                <button type="button" class="btn btn-sm btn-danger remove-step mt-2">Удалить шаг</button>
            `;
            
            container.appendChild(div);
        });

        // Удаление полей
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-ingredient')) {
                e.target.closest('.ingredient-group').remove();
                validateForm();
            }
            if (e.target.classList.contains('remove-step')) {
                e.target.closest('.step-group').remove();
                validateForm();
            }
        });

        // Валидация формы
        document.getElementById('recipe-form').addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
            }
        });

        function validateForm() {
            let isValid = true;
            
            // Валидация ингредиентов
            const ingredientsError = document.getElementById('ingredients-error');
            const ingredientGroups = document.querySelectorAll('.ingredient-group');
            
            if (ingredientGroups.length === 0) {
                ingredientsError.textContent = 'Добавьте хотя бы один ингредиент';
                ingredientsError.style.display = 'block';
                isValid = false;
            } else {
                ingredientsError.style.display = 'none';
                
                ingredientGroups.forEach(group => {
                    const select = group.querySelector('.ingredient-select');
                    const amount = group.querySelector('.ingredient-amount');
                    const error = group.querySelector('.ingredient-error');
                    
                    if (!select.value || !amount.value) {
                        error.textContent = 'Заполните все поля ингредиента';
                        error.style.display = 'block';
                        isValid = false;
                    } else {
                        error.style.display = 'none';
                    }
                });
            }
            
            // Валидация шагов
            const stepsError = document.getElementById('steps-error');
            const stepGroups = document.querySelectorAll('.step-group');
            
            if (stepGroups.length === 0) {
                stepsError.textContent = 'Добавьте хотя бы один шаг приготовления';
                stepsError.style.display = 'block';
                isValid = false;
            } else {
                stepsError.style.display = 'none';
                
                stepGroups.forEach(group => {
                    const textarea = group.querySelector('.step-description');
                    const error = group.querySelector('.step-error');
                    
                    if (!textarea.value.trim()) {
                        error.textContent = 'Описание шага не может быть пустым';
                        error.style.display = 'block';
                        isValid = false;
                    } else {
                        error.style.display = 'none';
                    }
                });
            }
            
            return isValid;
        }

        // Валидация при изменении полей
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('ingredient-select') || 
                e.target.classList.contains('ingredient-amount') ||
                e.target.classList.contains('step-description')) {
                validateForm();
            }
        });

        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('ingredient-select') || 
                e.target.classList.contains('ingredient-amount') ||
                e.target.classList.contains('step-description')) {
                validateForm();
            }
        });
    });
    </script>
</html>