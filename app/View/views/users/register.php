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
            ImportComponent::style('users.main');
        ?>
    </style>

    <title>Register</title>
</head>
<body>
<main class="container">
    <a class="title-container" href="/films">
        <div>Film-Service</div>
    </a>
    <div class="form-container">
        <form action="/users/store" method="post">
            <label for="login">Login : </label>
            <input name="login" id="login" type="text">

            <label for="password">Password : </label>
            <input name="password" id="password" type="text">

            <label for="password_repeat">Password repeat: </label>
            <input name="password_repeat" id="password_repeat" type="text">

            <button type="submit">Register</button>
        </form>
    </div>
    <div class="errors">
        <?= $formErrors ?? '' ?>
    </div>
    <a href="/users/login">
      Already registered?
    </a>
</main>
</body>
</html>