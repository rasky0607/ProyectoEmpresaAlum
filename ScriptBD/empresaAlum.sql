
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
		nombre varchar(40) default 'Vacio' not null,
		apellidos varchar(100) default 'Vacio' not null,
		anioPromocion integer default null,
		estadoLaboral enum('En paro','Activo') default 'En paro' not null, 
		trabajaEn varchar(150) default null,
		fechaContrato date default null,
		primary key(usuarioAlum),
		foreign key (usuarioAlum) references usuario (usuario) on update cascade on delete restrict		
		);


	create table empresa(
		usuarioEmp varchar(70),
		nombre varchar(150) default 'Vacio' not null,
		direccion varchar(200) default 'Vacio' not null,
		telefono varchar(12) default 'Vacio' not null,
		nombreContacto varchar(100) default 'Vacio' not null,
		primary key(usuarioEmp),
		foreign key (usuarioEmp) references usuario (usuario) on update cascade on delete restrict		

		);


	create table correo(
		idCorreo integer AUTO_INCREMENT,
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
insert into usuario (usuario,password,email,tipoUsuario)values('test1',password('123'),'test1@gmail.com','alumno');
insert into usuario (usuario,password,email,tipoUsuario)values('test2',password('123'),'test2@gmail.com','empresa');

insert into alumno (usuarioAlum,nombre,apellidos,anioPromocion,estadoLaboral,trabajaEn,fechaContrato)VALUES ('Esteban','Esteban','Gomez Ruiz',2019,'Activo','Prostitucion','19940122');
insert into alumno (usuarioAlum,nombre,apellidos,anioPromocion,estadoLaboral,trabajaEn,fechaContrato)VALUES ('Maria','Maria','Garcia Miralles',2019,'Activo','Monitora de ginasia ritmica','20100122');
insert into alumno (usuarioAlum,nombre,apellidos,anioPromocion)VALUES ('topete','Topete','Max Turbado',2017);
insert into alumno(usuarioAlum,nombre,apellidos,anioPromocion,estadoLaboral) values("CarmenDeMairena","Carmen","De Mairena Montenegro",2010,"En paro");
insert into alumno (usuarioAlum,nombre)VALUES ('test1','test1');

insert into empresa (usuarioEmp,nombre,direccion,telefono,nombreContacto) values('HugoBoss','The Hugo Boss S.A.','Calle de la piruleta','696969696','Hugo Madrid');
insert into empresa (usuarioEmp,nombre,direccion,telefono,nombreContacto) values('PatriCons','Patricia consoladores S.A.','Calle de la UCA','969696969','Patricia Barrilado Carranque');
insert into empresa (usuarioEmp,nombre,direccion,telefono,nombreContacto) values("caracol","Caracol derrapador poco mordedor S.L","Plaza caracola cuadrada",667907349,"Caracolis Herectus");
insert into empresa (usuarioEmp,nombre)VALUES ('test2','test2 S.L');

insert into correo(idCorreo,remitente,destinatario,fecha,asunto,contenido)values(1,'estebangomezruiz@gmail.com','mariagarciamiralles@gmail.com',20190119,'¿Que pasa paca?','Esto es el contenido del correo 1');
insert into correo(idCorreo,remitente,destinatario,fecha,asunto,contenido)values(2,'mariagarciamiralles@gmail.com','estebangomezruiz@gmail.com',20190119,'Aburrida','Esto es el contenido del correo 2');

insert into correo(idCorreo,remitente,destinatario,fecha,asunto,contenido)values(3,'TheHugoBoss@gmail.com','mariagarciamiralles@gmail.com',20190309,'Oferta de trabajo en Mascokotas','Esto es el contenido del correo 3');
insert into correo(idCorreo,remitente,destinatario,fecha,asunto,contenido)values(4,'PatriciaConsoladoresSA@gmail.com','estebangomezruiz@gmail.com',20190222,'Oferta de trabajo de psicologo','Esto es el contenido del correo 4');
insert into correo(idCorreo,remitente,destinatario,fecha,asunto,contenido)values(5,"TheHugoBoss@gmail.com","topete@gmail.com",20190219,"Oferta de trabajo vigilante de seguridad","Esto es el contenido del correo 5"); -- NUEVO
insert into correo(idCorreo,remitente,destinatario,fecha,asunto,contenido)values(6,"LaCarmensitaRechulona@gmail.com","mariagarciamiralles@gmail.com",20190219,'El miedo en mis ojos','Esto es el contenido del correo 6.Señora, usted me impone,de hecho se me escondio el testiculo izquierdo del susuto.');
insert into correo (remitente,destinatario,fecha,asunto,contenido)values('mariagarciamiralles@gmail.com','estebangomezruiz@gmail.com','2019-03-22','esto es una prueba','contenido de correo paca');



	/*Trigger para controlar:
	 cuando el campo trabajaEn esta lleno, el estado laboral pase a Activo y viceversa*/

	 
DELIMITER #
	 drop trigger if exists empresalum.bialumno#
	 create trigger empresalum.bialumno before insert on alumno
	 	for each row
	 	BEGIN
	 		if new.trabajaEn is not null or new.trabajaEn is not null and new.estadoLaboral='En paro' then
	 			 SET new.estadoLaboral ='Activo';
	 		end if;
	 		if new.trabajaEn is null and new.estadoLaboral='Activo' then
	 			 
	 			 SET new.estadoLaboral ='En paro';
	 		end if;
	 	END#
	 	 drop trigger if exists empresalum.bualumno#
	 	 create trigger empresalum.bualumno before update on alumno
	 	for each row
	 	BEGIN
	 		if new.trabajaEn is not null or new.trabajaEn is not null and new.estadoLaboral='En paro' then
	 			 SET new.estadoLaboral ='Activo';
	 		end if;
	 		if new.trabajaEn is null and new.estadoLaboral='Activo' then
	 			 SET new.estadoLaboral ='En paro';
	 		end if;
	 		
	 	END#
	 drop trigger if exists empresalum.aiusuario#
	 create trigger empresalum.aiusuario after insert on usuario
	 	for each row
	 	BEGIN
	 		if new.tipoUsuario='alumno' then
	 			 	insert into alumno(usuarioAlum)values(new.usuario); 		
	 		end if;

	 		if new.tipoUsuario='empresa' then
	 			 	insert into empresa(usuarioEmp)values(new.usuario);
	 		end if;
	 	END#


DELIMITER ;