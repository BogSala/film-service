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
    <title>Some error</title>
    <style>
        <?php
            use App\View\Components\ImportComponent;

            ImportComponent::style('system.main');
            ImportComponent::style('system.errors');
        ?>
    </style>

</head>
<body>
<?php $error = $error ?? 500 ?>
<main class="container">
    <div class="title-container">
        <div>Film-Service</div>
    </div>
    <div class="error-holder">
        <h1>
            We have troubles... Error code: <?=$error?>
        </h1>
        <a href="/films/index">
            Back to main page
        </a>
    </div>
</main>
</body>
</html>
