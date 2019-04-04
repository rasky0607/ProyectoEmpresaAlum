
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
		email varchar(150) UNIQUE not null ,
		tipoUsuario enum ('alumno','empresa') not null,
		primary key(usuario)
		);

	create table alumno(
		usuarioAlum varchar(70),
		nombre varchar(40) not null,
		apellidos varchar(100) not null,
		anioPromocion integer not null,
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
		nombreContacto varchar(100) not null,
		primary key(usuarioEmp),
		foreign key (usuarioEmp) references usuario (usuario) on update cascade on delete restrict		

		);


	create table correo(
		idCorreo integer,
		remitente varchar(150) not null,
		destinatario varchar(150) not null,
		fecha date not null,
		asunto varchar(150) not null,
		contenido varchar(255),
		primary key(idCorreo),
		foreign key (remitente) references usuario (email) on update cascade on delete restrict,
		foreign key (destinatario) references usuario (email) on update cascade on delete restrict

		);



insert into usuario (usuario,password,email,tipoUsuario) values('Esteban',password('123'),'estebangomezruiz@gmail.com','alumno');
insert into usuario (usuario,password,email,tipoUsuario) values('HugoBoss',password('123'),'TheHugoBoss@gmail.com','empresa');
insert into usuario (usuario,password,email,tipoUsuario) values('Maria',password('123'),'mariagarciamiralles@gmail.com','alumno');
insert into usuario (usuario,password,email,tipoUsuario) values('PatriCons',password('123'),'PatriciaConsoladoresSA@gmail.com','empresa');
insert into usuario (usuario,password,email,tipoUsuario) values('topete',password('123'),'topete@gmail.com','alumno');
insert into usuario (usuario,password,email,tipoUsuario) values("CarmenDeMairena",password('123'),"LaCarmensitaRechulona@gmail.com","alumno"); -- NUEVO
insert into usuario (usuario,password,email,tipoUsuario) values("caracol",password('123'),"ElCaracolQueDerrapa@gmail.com","empresa");



insert into alumno (usuarioAlum,nombre,apellidos,anioPromocion,estadoLaboral,trabajaEn,fechaContrato)VALUES ('Esteban','Esteban','Gomez Ruiz',2019,'Activo','Prostitucion','19940122');
insert into alumno (usuarioAlum,nombre,apellidos,anioPromocion,estadoLaboral,trabajaEn,fechaContrato)VALUES ('Maria','Maria','Garcia Miralles',2019,'Activo','Monitora de ginasia ritmica','20100122');
insert into alumno (usuarioAlum,nombre,apellidos,anioPromocion)VALUES ('topete','Topete','Max Turbado',2017);
insert into alumno(usuarioAlum,nombre,apellidos,aniopromocion,estadoLaboral) values("CarmenDeMairena","Carmen","De Mairena Montenegro",2010,"En paro");

insert into empresa (usuarioEmp,nombre,direccion,telefono,nombreContacto) values('HugoBoss','The Hugo Boss','Calle de la piruleta','696969696','Hugo Madrid');
insert into empresa (usuarioEmp,nombre,direccion,telefono,nombreContacto) values('PatriCons','Patricia consoladores S.A.','Calle de la UCA','969696969','Patricia Barrilado Carranque');
insert into empresa (usuarioEmp,nombre,direccion,telefono,nombreContacto) values("caracol","Caracol derrapador poco mordedor","Plaza caracola cuadrada",667907349,"Caracolis Herectus");


insert into correo(idCorreo,remitente,destinatario,fecha,asunto,contenido)values(1,'estebangomezruiz@gmail.com','mariagarciamiralles@gmail.com',20190119,'¿Que pasa paca?','Esto es el contenido del correo 1');
insert into correo(idCorreo,remitente,destinatario,fecha,asunto,contenido)values(2,'mariagarciamiralles@gmail.com','estebangomezruiz@gmail.com',20190119,'Aburrida','Esto es el contenido del correo 2');

insert into correo(idCorreo,remitente,destinatario,fecha,asunto,contenido)values(3,'TheHugoBoss@gmail.com','mariagarciamiralles@gmail.com',20190309,'Oferta de trabajo en Mascokotas','Esto es el contenido del correo 3');
insert into correo(idCorreo,remitente,destinatario,fecha,asunto,contenido)values(4,'PatriciaConsoladoresSA@gmail.com','estebangomezruiz@gmail.com',20190222,'Oferta de trabajo de psicologo','Esto es el contenido del correo 4');
insert into correo(idCorreo,remitente,destinatario,fecha,asunto,contenido)values(5,"TheHugoBoss@gmail.com","topete@gmail.com",20190219,"Oferta de trabajo vigilante de seguridad","Esto es el contenido del correo 5"); -- NUEVO
insert into correo(idCorreo,remitente,destinatario,fecha,asunto,contenido)values(6,"LaCarmensitaRechulona@gmail.com","mariagarciamiralles@gmail.com",20190219,"El miedo en mis ojos","Esto es el contenido del correo 6.Señora, usted me impone,de hecho se me escondio el testiculo izquierdo del susuto.");