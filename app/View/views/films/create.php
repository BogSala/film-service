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

    <title>Create</title>
    <style>
        <?php
            style('system.main');
        ?>
    </style>
</head>
<body>
<header class="header">
    <a class="link-main" href="/films/">
        Film-service
    </a>
    <div class="actions">
        <a href="/films/make-search" class="search">Search</a>
        <a href="/films/create" class="create">Create</a>
        <form action="/users/logout" method="post" class="logout-form">
            <button type="submit" class="logout-button" >Logout</button>
        </form>
    </div>

</header>
<hr>

<main class="container">
    <form action="/films/store" method="post" class="create-form">
        <label for="title">Title: </label>
        <input type="text" name="title" id="title" class="film-title">

        <label for="release_year">Release date: </label>
        <input type="number" name="release_year" id="release_year" class="film-release" step="1">

        <label for=format">Format:</label>
        <input type="text" name="format" id=format" class="film-format">

        <label for="stars">Stars: </label>
        <input type="text" name="stars" id="stars" class="stars" placeholder="Humphrey Bogart, Ingrid Bergman, Claude Rains, Peter Lorre">
        <button type="submit" class="create-button" >Create</button>
    </form>

    <div>Do you want a mass create? Use <a href="/films/import" class="import">Import</a></div>
    <div class="errors">
        <?= $formErrors ?? '' ?>
    </div>
</main>

</body>
</html>

