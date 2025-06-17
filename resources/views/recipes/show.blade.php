<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $recipe->title }} - Детали рецепта</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
    <style>
        .recipe-header {
            margin-bottom: 30px;

        }
        .recipe-image {
            max-height: 500px;
            object-fit: cover;
            border-radius: 8px;
        }
        .rating-stars {
            color: #ffc107;
            font-size: 24px;
        }
        .comment-section {
            margin-top: 40px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .comment {
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }
        .action-buttons {
            margin: 20px 0;
        }
            .rating-stars {
        display: inline-block;
        direction: rtl; /* Обратный порядок для правильного наведения */
        unicode-bidi: bidi-override;
    }
    .rating-stars input {
        display: none;
    }
    .rating-stars label {
        font-size: 1.5rem;
        color: #ddd;
        cursor: pointer;
        padding: 0 2px;
    }
    .rating-stars label:hover,
    .rating-stars label:hover ~ label,
    .rating-stars input:checked ~ label {
        color: #ffc107;
    }
    .rating-stars input:checked + label {
        color: #ffc107;
    }
        .comment-section {
        max-width: 800px;
        margin: 0 auto;
    }
    .avatar-placeholder {
        font-weight: bold;
        text-transform: uppercase;
    }
    .comment-content {
        white-space: pre-wrap;
        word-wrap: break-word;
    }
    body {
            margin: 0;  
            font-family: 'inter', sans-serif;
            color:#fff;
            background-image: url("/images/background.png");
            background-color:rgb(22, 22, 22);
            background-repeat: no-repeat;
            background-size: cover;
    }
    nav {
            display: flex;
            background-color: #252525;
            justify-content: space-between;
            padding: 0 70px;
            border-bottom: 1px solid #000;
            align-items: center;
            height: 60px;
            margin-bottom: 35px;
    }
    button,.btn{
            border-radius:6px;
            text-align: center;
            color:#F959C1;
            background-color: #fff;
            margin: auto;
            border:0;
            height: 30px;
            width: 100px;
            margin-top: 25px;margin-bottom: 10px; 

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
            color: #fff;
            transition: color 0.3s;
    }
    a:hover {
          color:#F959C1;
    }
    .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
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
button:hover,.btn:hover{
background: #F959C1;
color: white;
transition-duration: 0,5s;
}
footer{
margin-top: 150px;
display:flex;
justify-content: space-between;
background-color: #252525;
height: 339px;
padding: 50px 200px;
box-sizing:border-box;
}
.SubInfo{
display:flex;
width: 400px;
}
footer h1{
font-size: 24px;
font-weight: normal;
text-align: center;
margin: 0;
margin-bottom: 30px;
}
.Finfo{
display:flex;
flex-direction:column;
width: 173px;
border-left:1px solid #fff; 
width: 200px;
height: 200px;
}
footer ul{
flex-direction:column;
height: 100px;
gap:15px;
}
.logo{
width: 78px;
height: 35px;
margin: 0px;
}  
h3{
    color:#fff;
}
.card-body{
    background-color: #252525;
    color:#fff;
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

    <div class="container py-5">
        <div class="recipe-header">
            <h1>{{ $recipe->title }}</h1>
            <div class="d-flex align-items-center text-white mb-3">
                <span class="me-3"><i class="bi bi-clock"></i> {{ $recipe->cooking_time }} мин</span>
                <span class="me-3"><i class="bi bi-people"></i> {{ $recipe->servings }} порций</span>
                <span><i class="bi bi-speedometer2"></i> {{ $recipe->difficulty }}</span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                @if($recipe->image_url)
                    <img src="{{ asset($recipe->image_url) }}" alt="{{ $recipe->title }}" class="img-fluid recipe-image mb-4">
                    @else
            <img src="{{ asset('images/default.webp') }}" class="img-fluid recipe-image mb-4" alt="Default image">
                @endif

                <div class="card mb-4">
                    <div class="card-header" style="background-color:#0E0E0E;">
                        <h3 class="mb-0">Описание</h3>
                    </div>
                    <div class="card-body">
                        <p>{{ $recipe->description }}</p>
                    </div>
                </div>

               <div class="card mb-4">
    <div class="card-header"style="background-color:#0E0E0E;">
        <h3 class="mb-0">Ингредиенты</h3>
    </div>
    <div class="card-body">
        @if($recipe->ingredients()->count() > 0)
            <ul class="">
                @foreach($recipe->ingredients as $ingredient)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $ingredient->name }}
                        @if($ingredient->pivot->amount)
                            <span class="badge rounded-pill" style="background-color:#fff;color:#F959C1;"> {{ $ingredient->pivot->amount }} шт</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        @elseif($recipe->ingredients) <!-- Для обратной совместимости со старым форматом -->
            <ul>
                @foreach(explode("\n", $recipe->ingredients) as $ingredient)
                    @if(trim($ingredient))
                        <li>{{ $ingredient }}</li>
                    @endif
                @endforeach
            </ul>
        @else
            <div class="alert alert-warning">Ингредиенты не указаны</div>
        @endif
    </div>
</div>

<div class="card mb-4">
    <div class="card-header"style="background-color:#0E0E0E;">
        <h3 class="mb-0">Шаги приготовления</h3>
    </div>
    <div class="card-body">
        @if($recipe->steps()->count() > 0)
            <ol class="list-group list-group-numbered list-group-flush" style="background-color:#252525;">
                @foreach($recipe->steps()->orderBy('step_number')->get() as $step)
                    <li class="list-group-item d-flex justify-content-between align-items-start"style="background-color:#252525;color:#fff" >
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Шаг {{ $step->step_number }}</div>
                            {{ $step->description }}
                        </div>
                    </li>
                @endforeach
            </ol>
        @elseif($recipe->steps) <!-- Для обратной совместимости со старым форматом -->
            <ol>
                @foreach(explode("\n", $recipe->steps) as $step)
                    @if(trim($step))
                        <li>{{ $step }}</li>
                    @endif
                @endforeach
            </ol>
        @else
            <div class="alert alert-warning">Шаги приготовления не указаны</div>
        @endif
    </div>
</div>
    </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header" style="background-color:#0E0E0E;">
                        <h3 class="mb-0">Информация</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Категория:</strong> {{ $recipe->category->name }}</p>
                        <p><strong>Автор:</strong> {{ $recipe->user->name }}</p>
                        <p><strong>Дата добавления:</strong> {{ $recipe->created_at->format('d.m.Y') }}</p>
                    </div>
                </div>

                <div class="card mb-4"style="background-color: #252525;">
                    <div class="card-body action-buttons">
                        <form action="{{ route('favorites.toggle', $recipe) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn {{ $isFavorite ? 'btn-success' : 'btn-outline-secondary' }}"style="width:200px">
                                <i class="bi bi-heart{{ $isFavorite ? '-fill' : '' }}"></i>
                                {{ $isFavorite ? 'В избранном' : 'В избранное' }}
                            </button>
                        </form>

                  
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header"style="background-color:#0E0E0E;">
                        <h3 class="mb-0">Оцените рецепт</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('recipes.rate', $recipe) }}" method="POST" class="rating-form">
    @csrf
    <div class="rating-wrapper">
        <div class="rating-stars mb-2">
            @for($i = 5; $i >= 1; $i--)
                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}"
                       {{ $userRating && $userRating->rating == $i ? 'checked' : '' }}>
                <label for="star{{ $i }}" title="{{ $i }} звезд">
                    <i class="bi bi-star{{ $userRating && $userRating->rating >= $i ? '-fill' : '' }}"></i>
                </label>
            @endfor
        </div>
        
        <div class="rating-info small text-white mb-2">
            Средняя оценка: 
            <span class="text-warning fw-bold">{{ number_format($recipe->averageRating(), 1) }}</span>
            (оценок: {{ $recipe->ratingsCount() }})
        </div>
        
        <button type="submit" class="btn btn-primary btn-sm">Оценить</button>
    </div>
</form>
                    </div>
                </div>
            </div>
        </div>

<div class="comment-section mt-5">
    <h3 class="mb-4">Комментарии ({{ $recipe->comments()->count() }})</h3>
    
    @auth
        <form action="{{ route('comments.store', $recipe) }}" method="POST" class="mb-4">
            @csrf
            <div class="form-group">
                <textarea name="text" class="form-control" rows="3" 
                          placeholder="Оставьте ваш комментарий..." required style="background-color:#252525;color:#fff"></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Отправить</button>
        </form>
    @else
        <div class="alert alert-info">
            <a href="{{ route('login') }}" class="fw-bold">Войдите</a>, чтобы оставить комментарий
        </div>
    @endauth

    <div class="comments-list">
        @forelse($recipe->comments()->with('user')->latest()->get() as $comment)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-center">
                            <div class="user-avatar me-2">
                                @if($comment->user->avatar)
                                    <img src="{{ asset('storage/'.$comment->user->avatar) }}" 
                                         alt="{{ $comment->user->name }}" 
                                         class="rounded-circle" width="40">
                                @else
                                    <span class="avatar-placeholder bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                          style="width:40px; height:40px;">
                                        {{ substr($comment->user->name, 0, 1) }}
                                    </span>
                                @endif
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $comment->user->name }}</h6>
                                <small class="text-white">
                                    {{ $comment->created_at->format('d.m.Y H:i') }}
                                    <span class="ms-1">({{ $comment->created_at->diffForHumans() }})</span>
                                </small>
                            </div>
                        </div>
                        
                        @can('delete', $comment)
                            <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        @endcan
                    </div>
                    
                    <div class="comment-content mt-3">
                        {!! nl2br(e($comment->text)) !!}
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-secondary" style="background-color:#252525;color:#fff">Пока нет комментариев. Будьте первым!</div>
        @endforelse
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Простая валидация формы комментария
        document.querySelector('form[action*="comments"]')?.addEventListener('submit', function(e) {
            if (this.querySelector('textarea').value.trim().length < 5) {
                e.preventDefault();
                alert('Комментарий должен содержать не менее 5 символов');
            }
        });
    </script>
</body>
</html>