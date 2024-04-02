<?php

return "
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
);
";