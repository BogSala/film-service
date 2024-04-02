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
    <title>Access denied</title>
    <style>
        <?php
            style('system.main');
            style('system.errors');
        ?>
    </style>

</head>
<body>
<main class="container">
    <div class="title-container">
        <div>Film-Service</div>
    </div>
    <div class="error-holder">
        <h1>
            403 Access denied
        </h1>
        <a href="/users/login">
            Maybe you need to log in?
        </a>
    </div>

</main>
</body>
</html>