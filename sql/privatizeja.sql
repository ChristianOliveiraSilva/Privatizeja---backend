CREATE DATABASE privatizeja;
use privatizeja;

CREATE TABLE user_account(
    id serial not null PRIMARY KEY,
    name varchar(256) not null,
    email varchar(256) not null,
    login varchar(64),
    password varchar(256),
    cpf varchar(11) not null
);

CREATE TABLE company(
    id serial not null PRIMARY KEY,
    name varchar(256) not null,
    initials varchar(10),
    created date,
    cpf varchar(11),
    history varchar(1024) not null,
    logo varchar(256)
);

CREATE TABLE signature(
    id serial not null PRIMARY KEY,
    id_user_account int not null,
    id_company int not null,
    created date
);
