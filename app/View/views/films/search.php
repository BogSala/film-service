<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css"
    />
    <style>
        <?php
            use App\View\Components\ImportComponent;

            ImportComponent::style('system.main');
            ImportComponent::style('films.index');
        ?>
    </style>

    <title>Search</title>
</head>
<body>
<?php
use App\View\Components\FilmComponent;

$find = FilmComponent::getSearchHTMl();
?>
<header class="header">
    <a class="link-main" href="/films/">
        Film-service
    </a>
    <div class="actions">
        <a href="/films/search" class="search">Search</a>
        <a href="/films/create" class="create">Create</a>
        <form action="/users/logout" method="post" class="logout-form">
            <button type="submit" class="logout-button" >Logout</button>
        </form>
    </div>

</header>
<hr>

<main class="container">
    <form action="/films/make-search" method="post" class="create-form">
        <label for="search">What are you want from me? </label>
        <input type="text" name="search" id="search" class="search-input">

        <legend>Search type: </legend>
        <br>

        <label for="by_title">
            <input type="radio" checked="checked" id="by_title" name="search_type" value="title"/>
            Find by title</label>
        <label for="by_star">
            <input type="radio" id="by_star" name="search_type" value="stars"/>
            Find by actor name</label>
        <label for="both">
            <input type="radio" id="both" name="search_type" value="both"/>
            Both</label>

        <br>
        <button type="submit" class="search-button" >Search</button>
    </form>
    <?php
    if (is_array($find)){
        var_dump($find);
    }else{
        echo $find;
    }
    ?>
</main>

</body>
</html>

