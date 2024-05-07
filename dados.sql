/*Crie o banco de dados*/
CREATE DATABASE dados

/*Com o banco criado selecione ele e execute a criação das tabelas*/
CREATE TABLE dados_perfil (
    id int PRIMARY KEY NOT NULL AUTO_INCREMENT, 
    nome varchar (50), 
    idade int, 
    endereco varchar(100), 
    bio varchar(500)
    ); 

    CREATE TABLE imagens (
    id int PRIMARY KEY NOT NULL AUTO_INCREMENT, 
    caminho varchar(255) NULL,
    data_upload	timestamp
    ); 

    CREATE TABLE capa (
    id int PRIMARY KEY NOT NULL AUTO_INCREMENT, 
    caminho varchar(255) NULL,
    data_upload	timestamp
    ); 