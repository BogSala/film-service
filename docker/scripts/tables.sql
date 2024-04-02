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