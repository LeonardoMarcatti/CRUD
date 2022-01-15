create database CRUD;
use CRUD;

CREATE TABLE sex(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    gender CHAR(1) unique
);

CREATE TABLE client (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    sex INT UNSIGNED NOT NULL,
    constraint client_sex foreign key(sex) references sex(id)
);

create table users(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username varchar(100) not null unique,
    password varchar(100) not null unique,
    name varchar(100) not null,
    email varchar(40) default '' unique
);

create table image(
	id int not null auto_increment primary key,
	path varchar(100),
	id_user INT UNSIGNED NOT NULL,
	foreign key (id_user) references users(id) 
);

CREATE TABLE ddd(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    number INT NOT NULL UNIQUE
);

CREATE TABLE tipo_telefone(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(15) NOT NULL UNIQUE
);

CREATE TABLE telefone (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    number VARCHAR(12) NOT NULL,
    ddd INT UNSIGNED NOT NULL,
    CONSTRAINT telefone_ddd FOREIGN KEY(ddd) REFERENCES ddd(id),
    tipo INT UNSIGNED NOT NULL,
    CONSTRAINT telefone_tipo FOREIGN KEY(tipo) REFERENCES tipo_telefone(id)
);

CREATE TABLE client_telefone(
    id_cliente INT UNSIGNED not null,
    id_telefone INT UNSIGNED not null,
    PRIMARY KEY(id_cliente, id_telefone),
    CONSTRAINT  ct_telefone foreign key (id_telefone) references telefone(id),
    CONSTRAINT ct_cliente foreign key (id_cliente) references client(id)
);

CREATE TABLE bairro (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(30) NOT NULL UNIQUE
);

CREATE TABLE cidade (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(30) NOT NULL
);

create table estado(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(20) NOT NULL UNIQUE
);

CREATE TABLE tipo_logradouro (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(10) NOT NULL
);

CREATE TABLE endereco(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name_logradouro VARCHAR(30),
    complement VARCHAR(30),
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

create table endereco_client(
	id_cliente INT UNSIGNED not null,
    id_endereco INT UNSIGNED not null,
    PRIMARY KEY(id_cliente, id_endereco),
    constraint ec_client foreign key(id_cliente) references client(id),
    constraint ec_endereco foreign key(id_endereco) references endereco(id)
);

CREATE TABLE email(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    address VARCHAR(50) unique,
    client_id INT UNSIGNED NOT NULL unique,
    CONSTRAINT email_cliente FOREIGN KEY(client_id) REFERENCES client(id)
);

delimiter $
CREATE PROCEDURE insert_estado()
begin
	INSERT INTO estado(name) VALUES('Acre');
    INSERT INTO estado(name) VALUES('Alagoas');
    INSERT INTO estado(name) VALUES('Amapá');
    INSERT INTO estado(name) VALUES('Amazonas');
    INSERT INTO estado(name) VALUES('Bahia');
	INSERT INTO estado(name) VALUES('Ceará');
    INSERT INTO estado(name) VALUES('Distrito Federal');
    INSERT INTO estado(name) VALUES('Espírito Santo');
    INSERT INTO estado(name) VALUES('Goiás');
    INSERT INTO estado(name) VALUES('Maranhão');
	INSERT INTO estado(name) VALUES('Mato Grosso');
    INSERT INTO estado(name) VALUES('Mato Grosso do Sul');
    INSERT INTO estado(name) VALUES('Minas Gerais');
    INSERT INTO estado(name) VALUES('Pará');
    INSERT INTO estado(name) VALUES('Paraiba');
	INSERT INTO estado(name) VALUES('Paraná');
    INSERT INTO estado(name) VALUES('Pernanbuco');
    INSERT INTO estado(name) VALUES('Piauí');
    INSERT INTO estado(name) VALUES('Rio de Janeiro');
    INSERT INTO estado(name) VALUES('Rio Grande do Norte');
	INSERT INTO estado(name) VALUES('Rio Grande do Sul');
    INSERT INTO estado(name) VALUES('Rondônia');
    INSERT INTO estado(name) VALUES('Roraima');
    INSERT INTO estado(name) VALUES('Santa Catarina');
    INSERT INTO estado(name) VALUES('São Paulo');
    INSERT INTO estado(name) VALUES('Sergipe');
    INSERT INTO estado(name) VALUES('Tocantins');
end;
$
delimiter ;

call insert_estado();

delimiter $
CREATE PROCEDURE insert_tipo_telefone()
begin
	INSERT INTO tipo_telefone(tipo) VALUES('Residencial');
    INSERT INTO tipo_telefone(tipo) VALUES('Comercial');
	INSERT INTO tipo_telefone(tipo) VALUES('Celular');
	INSERT INTO tipo_telefone(tipo) VALUES('Outros');
end;
$
delimiter ;

call insert_tipo_telefone();

delimiter $
CREATE PROCEDURE insert_sex()
begin
	INSERT INTO sex(gender) VALUES('F');
    INSERT INTO sex(gender) VALUES('M');
end;
$
delimiter ;

call insert_sex();

delimiter $
CREATE PROCEDURE insert_tipo_logradouro()
begin
	INSERT INTO tipo_logradouro(name) VALUES('Avenida');
    INSERT INTO tipo_logradouro(name) VALUES('Rua');
    INSERT INTO tipo_logradouro(name) VALUES('Alameda');
    INSERT INTO tipo_logradouro(name) VALUES('Praça');
    INSERT INTO tipo_logradouro(name) VALUES('Beco');
    INSERT INTO tipo_logradouro(name) VALUES('Via');
    INSERT INTO tipo_logradouro(name) VALUES('Travessa');
end;
$
delimiter ;

call insert_tipo_logradouro();

delimiter $
CREATE PROCEDURE erase()
begin
delete from client_telefone where id_cliente  >= 1;
delete from endereco_client where id_cliente >= 1;
delete from email where cliente_id >= 1;
alter TABLE email AUTO_INCREMENT = 1;
delete from telefone where id >= 1;
alter TABLE telefone AUTO_INCREMENT = 1;
delete from ddd where id >= 1;
alter TABLE ddd AUTO_INCREMENT = 1;
delete from client where id >= 1;
alter TABLE client AUTO_INCREMENT = 1;
delete from endereco where id >= 1;
alter TABLE endereco AUTO_INCREMENT = 1;
delete from bairro where id >= 1;
alter TABLE bairro AUTO_INCREMENT = 1;
delete from cidade where id >= 1;
alter TABLE cidade AUTO_INCREMENT = 1;
end;
$
delimiter ;

CREATE view	v_tudo as select en.id as 'id_endereco', cl.id, cl.name, s.gender, tl.id as 'id_logradouro', tl.name AS 'tipo_logradouro', en.name_logradouro as 'logradouro', en.numero, en.complement as 'complemento', ba.id as 'id_bairro', ba.name as 'bairro', ci.name as'cidade', es.id as 'id_estado', es.name as 'estado', e.id as 'id_email', e.address as 'email', tt.id as 'tipo_telefone', tt.tipo as 'tipo', d.id as 'id_ddd', d.number as 'ddd', t.id as 'id_telefone', t.number as 'telefone' from endereco_client ec join client cl on ec.id_cliente = cl.id join endereco en on en.id = ec.id_endereco join bairro ba on en.bairro = ba.id join cidade ci on ci.id = en.cidade join estado es on es.id = en.estado join tipo_logradouro tl on tl.id = en.tipo_logradouro left join email e on e.client_id = cl.id join client_telefone ct on  ct.id_cliente = cl.id join telefone t on ct.id_telefone = t.id join tipo_telefone tt on t.tipo = tt.id join ddd d on d.id = t.ddd join sex s on cl.sex = s.id ORDER BY cl.id;

delimiter $
CREATE PROCEDURE eraseClient(id int)
begin
	prepare client_telefone from
		'delete from client_telefone where id_cliente = ?';
    set @id = id;
    execute client_telefone using @id;
    prepare endereco_client from
		'delete from endereco_client where id_cliente = ?';
	set @id = id;
    execute endereco_client using @id;
    prepare deleteEmail from 
		'delete from email where client_id = ?';
	set @id = id;
    execute deleteEmail using @id;
    prepare deleteClient from 
		'delete from client where id = ?';
	set @id = id;
    execute deleteClient using @id;
end;
$
delimiter ;
