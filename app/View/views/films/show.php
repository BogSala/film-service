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
            style('system.main');
            style('films.show');
        ?>
    </style>

    <title>Film</title>
</head>
<body>
<?php
use App\View\Components\FilmComponent;
$film = $film ?? [];

$filmHTML = FilmComponent::prepareFilmHTML($film);

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
    <?=$filmHTML?>
</main>
</body>
</html>