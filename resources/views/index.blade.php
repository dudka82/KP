<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная</title>
</head>
<style>
    body{
        margin: 0;  
    }
    nav{
        display: flex;
        justify-content: space-between;
        padding:0 70px;
        border-bottom:1px solid #000;
    }
    ul{
        display: flex;
        gap:100px;
          list-style: none;
    }
    li{
          list-style: none;
    }
    a{
        text-decoration: none;
        color:#000;
    }
    .slider{
width: 700px;
height: 500px;
    }
    h1{
        font-size:24px;
        margin-left: 200px;
        font-weight: normal;
    }
</style>
<body>
    <nav>
        <img src="" alt="logo">
        <ul>
            <li><a href="">Главная</a></li>
            <li><a href="">Поиск</a></li>
            <li><a href="">Лучшее</a></li>
        </ul>
        <ul>
            <li><a href="">Добавить рецепт</a></li>
            <li><a href="">Войти</a></li>
        </ul>
    </nav>
    <main>
<div class="slider"></div>
<div class="recipes_list">
    <h1>Популярные рецепты</h1>
     

</div>
    </main>
</body>
</html>