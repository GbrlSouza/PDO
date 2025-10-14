create database pdo;
use pdo;
create table pessoa (
    id int not null primary key auto_increment,
    nome varchar(50) not null,
    email varchar(50) not null,
    telefone varchar(15) not null
);
insert into pessoa (nome, email, telefone) values ('teste', 'teste', 'teste');
