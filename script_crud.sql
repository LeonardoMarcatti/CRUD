CREATE DATABASE CRUD;
use CRUD;
create table users(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome_de_usuario varchar(100) not null unique,
    senha varchar(100) not null unique,
    nome varchar(100) not null
);

create table image(
id int not null auto_increment primary key,
caminho varchar(100),
iduser INT UNSIGNED NOT NULL,
foreign key (iduser) references users(id) 
);

CREATE TABLE sexo(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    genero CHAR(1) unique
);

CREATE TABLE cliente (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(30) NOT NULL,
    sexo INT UNSIGNED NOT NULL,
    constraint cliente_sexo foreign key(sexo) references sexo(id)
);

CREATE TABLE tipo_telefone(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(15) NOT NULL UNIQUE
);

CREATE TABLE ddd(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    numero INT NOT NULL UNIQUE
);

CREATE TABLE telefone (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    numero VARCHAR(12) NOT NULL,
    ddd INT UNSIGNED NOT NULL,
    CONSTRAINT telefone_ddd FOREIGN KEY(ddd) REFERENCES ddd(id),
    tipo INT UNSIGNED NOT NULL,
    CONSTRAINT telefone_tipo FOREIGN KEY(tipo) REFERENCES tipo_telefone(id)
);

CREATE TABLE cliente_telefone(
    id_cliente INT UNSIGNED not null,
    id_telefone INT UNSIGNED not null,
    PRIMARY KEY(id_cliente, id_telefone)
);

alter table cliente_telefone add constraint foreign key (id_telefone) references telefone(id);
alter table cliente_telefone add constraint foreign key (id_cliente) references cliente(id);

CREATE TABLE bairro (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nome VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE cidade (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nome VARCHAR(30) NOT NULL UNIQUE
);

alter table cidade change column nome nome VARCHAR(30) NOT NULL UNIQUE;

create table estado(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome varchar(20) NOT NULL UNIQUE
);

CREATE TABLE tipo_logradouro (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nome VARCHAR(10) NOT NULL
);

CREATE TABLE endereco(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome_logradouro VARCHAR(30),
    complemento VARCHAR(30),
    bairro INT UNSIGNED NOT NULL,
    CONSTRAINT endereco_bairro FOREIGN KEY(bairro) REFERENCES bairro(id),
    tipo_logradouro INT UNSIGNED NOT NULL,
    CONSTRAINT endereco_tipo_logradouro FOREIGN KEY(tipo_logradouro) REFERENCES tipo_logradouro(id),
    cidade INT UNSIGNED NOT NULL,
    CONSTRAINT endereco_cidade FOREIGN KEY(cidade) REFERENCES cidade(id),
    estado int unsigned not null,
    constraint endereco_estado foreign key(estado) references estado(id),
    numero int unsigned not null
);

create table endereco_cliente(
	id_cliente INT UNSIGNED not null,
    id_endereco INT UNSIGNED not null,
    PRIMARY KEY(id_cliente, id_endereco)
);

alter table endereco_cliente ADD CONSTRAINT id_endereco FOREIGN KEY(id_endereco) REFERENCES endereco(id);
alter table endereco_cliente ADD CONSTRAINT id_cliente FOREIGN KEY(id_cliente) REFERENCES cliente(id);

CREATE TABLE email(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    endereco VARCHAR(50) unique,
    cliente_id INT UNSIGNED NOT NULL unique,
    CONSTRAINT email_cliente FOREIGN KEY(cliente_id) REFERENCES cliente(id)
);

delimiter //
CREATE PROCEDURE tipo_telefone()
begin
	insert into tipo_telefone(tipo) value('Outro');
    insert into tipo_telefone(tipo) value('Residencial');
    insert into tipo_telefone(tipo) value('Comercial');
    insert into tipo_telefone(tipo) value('Celular');
end;
//
delimiter ;
call tipo_telefone();
drop procedure tipo_telefone;

delimiter //
CREATE PROCEDURE tipo_logradouro()
begin
	insert into tipo_logradouro(nome) value('Beco');
    insert into tipo_logradouro(nome) value('Rua');
    insert into tipo_logradouro(nome) value('Avenida');
    insert into tipo_logradouro(nome) value('Alameda');
    insert into tipo_logradouro(nome) value('Praça');
    insert into tipo_logradouro(nome) value('Via');
end;
//
delimiter ;
call tipo_logradouro();

delimiter //
CREATE PROCEDURE insert_estado()
begin
	INSERT INTO estado(nome) VALUES('Acre');
    INSERT INTO estado(nome) VALUES('Alagoas');
    INSERT INTO estado(nome) VALUES('Amapá');
    INSERT INTO estado(nome) VALUES('Amazonas');
    INSERT INTO estado(nome) VALUES('Bahia');
	INSERT INTO estado(nome) VALUES('Ceará');
    INSERT INTO estado(nome) VALUES('Distrito Federal');
    INSERT INTO estado(nome) VALUES('Espírito Santo');
    INSERT INTO estado(nome) VALUES('Goiás');
    INSERT INTO estado(nome) VALUES('Maranhão');
	INSERT INTO estado(nome) VALUES('Mato Grosso');
    INSERT INTO estado(nome) VALUES('Mato Grosso do Sul');
    INSERT INTO estado(nome) VALUES('Minas Gerais');
    INSERT INTO estado(nome) VALUES('Pará');
    INSERT INTO estado(nome) VALUES('Paraiba');
	INSERT INTO estado(nome) VALUES('Paraná');
    INSERT INTO estado(nome) VALUES('Pernanbuco');
    INSERT INTO estado(nome) VALUES('Piauí');
    INSERT INTO estado(nome) VALUES('Rio de Janeiro');
    INSERT INTO estado(nome) VALUES('Rio Grande do Norte');
	INSERT INTO estado(nome) VALUES('Rio Grande do Sul');
    INSERT INTO estado(nome) VALUES('Rondônia');
    INSERT INTO estado(nome) VALUES('Roraima');
    INSERT INTO estado(nome) VALUES('Santa Catarina');
    INSERT INTO estado(nome) VALUES('São Paulo');
    INSERT INTO estado(nome) VALUES('Sergipe');
    INSERT INTO estado(nome) VALUES('Tocantins');
end;
//
delimiter ;

call insert_estado();
drop procedure insert_estado;

delimiter //
CREATE PROCEDURE sexo()
begin
	insert into sexo(genero) value('M');
    insert into sexo(genero) value('F');
end;
//
delimiter ;
call sexo();

CREATE view	v_tudo as select en.id as 'id_endereco', cl.id, cl.nome, s.genero, tl.id as 'id_logradouro', tl.nome AS 'tipo_logradouro', en.nome_logradouro as 'logradouro', en.numero, en.complemento as 'complemento', ba.id as 'id_bairro', ba.nome as 'bairro', ci.nome as'cidade', es.id as 'id_estado', es.nome as 'estado', e.id as 'id_email', ifnull(e.endereco, '-') as 'email', tt.id as 'tipo_telefone', d.id as 'id_ddd', d.numero as 'ddd', t.id as 'id_telefone', t.numero as 'telefone' from endereco_cliente ec join cliente cl on ec.id_cliente = cl.id join endereco en on en.id = ec.id_endereco join bairro ba on en.bairro = ba.id join cidade ci on ci.id = en.cidade join estado es on es.id = en.estado join tipo_logradouro tl on tl.id = en.tipo_logradouro left join email e on e.cliente_id = cl.id join cliente_telefone ct on  ct.id_cliente = cl.id join telefone t on ct.id_telefone = t.id join tipo_telefone tt on t.tipo = tt.id join ddd d on d.id = t.ddd join sexo s on cl.sexo = s.id ORDER BY cl.id;