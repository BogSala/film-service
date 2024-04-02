<?php

try {
    $data = include_once (dirname(__FILE__) .'/configs/database.php');
} catch (Exception $e) {
    $data = include_once (dirname(__FILE__) .'/film-service/configs/database.php');
}

$db = new PDO("mysql:host=$data[host];dbname=$data[dbname]", $data["username"], $data["password"]);
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
$sql ="
    create table if not exists users
    (
        id       int auto_increment,
        login    text not null,
        password text not null,
        constraint id
            primary key (id),
        constraint login
            unique (login(255))
    );
    ";
$db->exec($sql);
$sql ="
        create table if not exists films
        (
            id           int auto_increment,
            user_id      int          not null,
            title        TEXT         not null,
            release_year SMALLINT     not null,
            format       VARCHAR(255) not null,
            stars        TEXT         not null,
            constraint id
                primary key (id),
            constraint user
                foreign key (user_id) references users (id)
        )
    ";
$db->exec($sql);
echo "Tables created\n";
die();
try {
    $db = new PDO("mysql:host=$data[host];dbname=$data[dbname]", $data["username"], $data["password"]);
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $sql ="
    create table users
    (
        id       int auto_increment,
        login    text not null,
        password text not null,
        constraint id
            primary key (id),
        constraint login
            unique (login(255))
    );
    ";
    $db->exec($sql);
    $sql ="
        create table films
        (
            id           int auto_increment,
            user_id      int          not null,
            title        TEXT         not null,
            release_year SMALLINT     not null,
            format       VARCHAR(255) not null,
            stars        TEXT         not null,
            constraint id
                primary key (id),
            constraint user
                foreign key (user_id) references users (id)
        )
    ";
    $db->exec($sql);
    echo "Tables created\n";
} catch(PDOException $e) {
    echo "Something went wrong..\n";
}