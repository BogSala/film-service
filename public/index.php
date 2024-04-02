<?php
use src\App;

session_start();
require "../vendor/autoload.php";
require "../app/routes.php";
require "../src/globals/functions.php";

define("ROOT_PATH" , dirname(__DIR__, 1).'/');

App::run();