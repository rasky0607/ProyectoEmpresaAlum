
-- Tabla usuario
-- Tabla empresa
-- Tabla correos
create database  if not exists empresalum character set ='utf8mb4';
	use empresalum;

	drop table if exists correosEmpresa;
	drop table if exists correosUsuarios;
	drop table if exists empresa;
	drop table if exists alumno;
	drop table if exists usuario;

	create table usuario(
		usuario varchar(70),
		password varchar(150) not null,
		tipoUsuario enum ('alumno','empresa') not null,
		primary key(usuario)
		);

	create table alumno(
		usuarioAlum varchar(70),
		nombre varchar(40) not null,
		apellidos varchar(100) not null,
		anioPromocion integer not null,
		email varchar(150) UNIQUE not null ,
		estadoLaboral enum('En paro','Activo') default 'En paro', 
		trabajaEn varchar(150) default null,
		fechaContrato date default null,
		primary key(usuarioAlum),
		foreign key (usuarioAlum) references usuario (usuario) on update cascade on delete restrict		
		);


	create table empresa(
		usuarioEmp varchar(70),
		nombre varchar(150) not null,
		direccion varchar(200) not null,
		telefono varchar(12) not null,
		email varchar(150) UNIQUE not null,
		nombreContacto varchar(100) not null,
		primary key(usuarioEmp),
		foreign key (usuarioEmp) references usuario (usuario) on update cascade on delete restrict		

		);


	create table correosAlumno(
		idCorreo integer,
		remitente varchar(150) not null,
		destinatario varchar(150) not null,
		fecha date not null,
		asunto varchar(150) not null,
		primary key(idCorreo),
		foreign key (remitente) references alumno (email) on update cascade on delete restrict,
		foreign key (destinatario) references alumno (email) on update cascade on delete restrict

		);

	create table correosEmpresa(
		idCorreo integer,
		remitente varchar(150) not null,
		destinatario varchar(150) not null,
		fecha date not null,
		asunto varchar(150) not null,
		primary key(idCorreo),
		foreign key (remitente) references empresa (email) on update cascade on delete restrict,
		foreign key (destinatario) references alumno (email) on update cascade on delete restrict
		);


insert into usuario (usuario,password,tipoUsuario) values('Esteban',password('123'),'alumno');
insert into usuario (usuario,password,tipoUsuario) values('HugoBoss',password('123'),'empresa');
insert into usuario (usuario,password,tipoUsuario) values('Maria',password('123'),'alumno');
insert into usuario (usuario,password,tipoUsuario) values('PatriCons',password('123'),'empresa');
insert into usuario (usuario,password,tipoUsuario) values('topete',password('123'),'alumno');


insert into alumno (usuarioAlum,nombre,apellidos,anioPromocion,email,estadoLaboral,trabajaEn,fechaContrato)VALUES ('Esteban','Esteban','Gomez Ruiz',2019,'estebangomezruiz@gmail.com','Activo','Prostitucion','19940122');
insert into alumno (usuarioAlum,nombre,apellidos,anioPromocion,email,estadoLaboral,trabajaEn,fechaContrato)VALUES ('Maria','Maria','Garcia Miralles',2019,'mariagarciamiralles@gmail.com','Activo','Monitora de ginasia ritmica','20100122');
insert into alumno (usuarioAlum,nombre,apellidos,anioPromocion,email)VALUES ('topete','Topete','Max Turbado',2017,'topete@gmail.com');

insert into empresa (usuarioEmp,nombre,direccion,telefono,email,nombreContacto) values('HugoBoss','The Hugo Boss','Calle de la piruleta','696969696','TheHugoBoss@gmail.com','Hugo Madrid');
insert into empresa (usuarioEmp,nombre,direccion,telefono,email,nombreContacto) values('PatriCons','Patricia consoladores S.A.','Calle de la UCA','969696969','PatriciaConsoladoresSA@gmail.com','Patricia Barrilado Carranque');

insert into correosAlumno(idCorreo,remitente,destinatario,fecha,asunto)values(1,'estebangomezruiz@gmail.com','mariagarciamiralles@gmail.com',20190119,'¿Que pasa paca?');
insert into correosAlumno(idCorreo,remitente,destinatario,fecha,asunto)values(2,'mariagarciamiralles@gmail.com','estebangomezruiz@gmail.com',20190119,'Aburrida');

insert into correosEmpresa(idCorreo,remitente,destinatario,fecha,asunto)values(3,'TheHugoBoss@gmail.com','mariagarciamiralles@gmail.com',20190309,'Oferta de trabajo en Mascokotas');
insert into correosEmpresa(idCorreo,remitente,destinatario,fecha,asunto)values(4,'PatriciaConsoladoresSA@gmail.com','estebangomezruiz@gmail.com',20190222,'Oferta de trabajo de psicologo');
