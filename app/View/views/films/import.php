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
            ImportComponent::style('films.import');
        ?>
    </style>

    <title>Import</title>
</head>
<body>
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
    <form action="/films/mass-store" enctype="multipart/form-data" method="post" class="create-form">
        <label for="import">Import data: </label>
        <input type="file" id="import" name="import">
        <button type="submit" class="delete-button" >Import</button>
    </form>
    <div class="errors">
        <?= $formErrors ?? '' ?>
    </div>
    <div class="example">
        <strong>Example form of importing:</strong>

        Title: Blazing Saddles
        Release Year: 1974
        Format: VHS
        Stars: Mel Brooks, Clevon Little, Harvey Korman, Gene Wilder, Slim Pickens, Madeline Kahn


        Title: Casablanca
        Release Year: 1942
        Format: DVD
        Stars: Humphrey Bogart, Ingrid Bergman, Claude Rains, Peter Lorre
    </div>

</main>

</body>
</html>

