<?php

return "
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