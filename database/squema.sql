SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

drop TABLE if EXISTS ciclos;
drop TABLE if EXISTS materias;
drop TABLE if EXISTS grupos;
drop TABLE if EXISTS grados;
drop TABLE if EXISTS alumnos;


create table ciclos(
    id bigint unsigned primary key auto_increment,
    nombre varchar(200) not null unique,
    status enum('activo','noactivo') default 'noactivo',
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

create table grados(
    id bigint unsigned primary key auto_increment,
    nombre varchar(200) not null unique,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

create table materias(
    id bigint unsigned primary key auto_increment,
    nombre varchar(200) not null unique,
    plan text,
    grado_id bigint unsigned not null,
    foreign key(grado_id) references grados(id) on delete cascade,
     created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

create table grupos(
    id bigint unsigned primary key auto_increment,
    nombre varchar(200) not null unique,
     created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);


create table alumnos( 
  id bigint unsigned  primary key auto_increment, 
  materno varchar(150)  not null ,
  paterno varchar(150)  not null,
  nombre varchar(200)  not null,
  user_id bigint unsigned,
  foreign key(user_id) references users(id) on delete cascade,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);



create table profesores( 
  id bigint unsigned  primary key auto_increment, 
  materno varchar(150)  not null, 
  paterno varchar(150)  not null,
  nombre varchar(200)  not null,
  user_id bigint unsigned,
  foreign key(user_id) references users(id) on delete cascade,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);


create table tutores( 
  id bigint unsigned  primary key auto_increment, 
  materno varchar(150)  not null, 
  paterno varchar(150)  not null,
  nombre varchar(200)  not null,
  user_id bigint unsigned,
  foreign key(user_id) references users(id) on delete cascade,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

create table alumnos_on_tutores(
    id bigint unsigned  primary key auto_increment, 
    tutor_id bigint unsigned  not null,
    foreign key(tutor_id) references tutores(id) on delete cascade,
    alumno_id bigint unsigned  not null,
    foreign key(alumno_id) references alumnos(id) on delete cascade,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);


create table inscripciones(
    id bigint unsigned  primary key auto_increment, 
    turno enum('matutino','vespertino','discontinuo') default 'matutino',
    alumno_id bigint unsigned  not null,
    foreign key(alumno_id) references alumnos(id) on delete cascade,
    grupo_id bigint unsigned  not null,
    foreign key(grupo_id) references grupos(id) on delete cascade,
    ciclo_id bigint unsigned  not null,
    foreign key(ciclo_id) references ciclos(id) on delete cascade,
    grado_id bigint unsigned  not null,
    foreign key(grado_id) references grados(id) on delete cascade,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

create table clases(
    id bigint unsigned  primary key auto_increment, 
    turno enum('matutino','vespertino','discontinuo') default 'matutino',
    profesor_id bigint unsigned  not null,
    foreign key(profesor_id) references profesores(id) on delete cascade,
    grupo_id bigint unsigned  not null,
    foreign key(grupo_id) references grupos(id) on delete cascade,
    ciclo_id bigint unsigned  not null,
    foreign key(ciclo_id) references ciclos(id) on delete cascade,
    grado_id bigint unsigned  not null,
    foreign key(grado_id) references grados(id) on delete cascade,
    materia_id bigint unsigned  not null,
    foreign key(materia_id) references materias(id) on delete cascade,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

create table parciales(
    id bigint unsigned  primary key auto_increment,
    nombre varchar(150)  not null,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

create table calificaciones(
    id bigint unsigned  primary key auto_increment, 
    calificacion float,
    clase_id bigint unsigned,
    foreign key(clase_id) references clases(id) on delete cascade,
    alumno_id bigint unsigned,
    foreign key(alumno_id) references alumnos(id) on delete cascade,
    parciales_id bigint unsigned,
    foreign key(parciales_id) references parciales(id) on delete cascade,
   created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);


create table calificaciones_finales(
    id bigint unsigned  primary key auto_increment, 
    calificacion float not null,
    clase_id bigint unsigned not null,
    foreign key(clase_id) references clases(id) on delete cascade,
    alumno_id bigint unsigned not null,
    foreign key(alumno_id) references alumnos(id) on delete cascade,
   created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

create table asistencias(
    id bigint unsigned  primary key auto_increment, 
    tipo enum('asistencia','falta','retardo') not null,
    clase_id bigint unsigned  not null,
    foreign key(clase_id) references clases(id) on delete cascade,
    alumno_id bigint unsigned  not null,
    foreign key(alumno_id) references alumnos(id) on delete cascade,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
)


create table noticias(
    id bigint unsigned  primary key auto_increment, 
    title varchar(250) not null,
    body text not null,
    img text not null,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);



insert into ciclos(nombre, status) values ('2020B','activo');
insert into grados(nombre) values ('1° Semestre'), ('2° Semestre'),('3° Semestre'), ('4° Semestre'), ('5° Semestre'), ('6° Semestre');
insert into grupos(nombre) values ('A'), ('B'),('C');


insert into materias(nombre, grado_id, plan) 
values('Español',1,'Reprehenderit aliqua tempor dolore aliqua occaecat. Dolore incididunt qui esse nulla id. Ipsum non esse et laboris. Laboris qui excepteur sit cupidatat proident officia in est enim. Exercitation magna ipsum consectetur nulla ad eiusmod tempor do do. Veniam qui dolor id anim quis.'),
('Matemáticas',1,"Duis enim consequat ea tempor id dolore aliqua culpa cillum occaecat ut minim duis magna. Deserunt cupidatat culpa id ea cupidatat. Sunt cillum sunt dolor nostrud fugiat cillum labore proident exercitation nostrud proident do. Et et adipisicing duis duis adipisicing ipsum elit proident voluptate cupidatat velit consequat in. Tempor elit ullamco est incididunt non commodo est incididunt sunt esse. Minim non sint deserunt labore commodo sit occaecat ipsum nostrud ea fugiat aliquip aliqua exercitation."), 
('Historia',1,"Mollit consectetur mollit quis duis exercitation velit anim in esse quis incididunt. Dolore exercitation in excepteur sint et ad pariatur aute ea amet nostrud velit. Sunt dolore anim consequat ea. Amet nisi elit laborum qui aliqua. Labore velit nostrud mollit laboris sint commodo fugiat quis consectetur."), 
('Inglés',1,"Nisi in proident occaecat amet. Non ullamco aliquip sint nisi ut culpa ex adipisicing eu nulla elit veniam. Velit anim magna incididunt adipisicing nisi sunt proident eiusmod fugiat nulla sunt nostrud non aute. Lorem reprehenderit elit dolore quis adipisicing ipsum consectetur minim. Voluptate ex fugiat veniam aute anim sunt.");

insert into alumnos(nombre,paterno,materno,user_id) values ('Jovanny','Ramírez','Chimal',1),('Valentín','Abundo','Hernandez',2);

insert into inscripciones(alumno_id, grado_id, grupo_id,ciclo_id) values(1,1,1,1),(2,1,1,1);



