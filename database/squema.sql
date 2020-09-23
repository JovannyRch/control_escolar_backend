drop TABLE if EXISTS ciclos;
drop TABLE if EXISTS materias;
drop TABLE if EXISTS grupos;
drop TABLE if EXISTS grados;
drop TABLE if EXISTS alumnos;


create table ciclos(
    id bigint unsigned primary key auto_increment,
    nombre varchar(200) not null unique,
    status enum('activo','no') default 'no'
);

create table grados(
    id bigint unsigned primary key auto_increment,
    nombre varchar(200) not null unique
);

create table materias(
    id bigint unsigned primary key auto_increment,
    nombre varchar(200) not null unique,
    plan text,
    grado_id bigint unsigned not null,
    foreign key(grado_id) references grados(id)
);

create table grupos(
    id bigint unsigned primary key auto_increment,
    nombre varchar(200) not null unique
);


create table alumnos( 
  id bigint unsigned  primary key auto_increment, 
  materno varchar(150),
  paterno varchar(150),
  nombre varchar(200),
  user_id bigint unsigned,
  foreign key(user_id) references users(id)
);



create table profesores( 
  id bigint unsigned  primary key auto_increment, 
  materno varchar(150), 
  paterno varchar(150),
  nombre varchar(200),
  user_id bigint unsigned,
  foreign key(user_id) references users(id)
);


create table tutores( 
  id bigint unsigned  primary key auto_increment, 
  materno varchar(150), 
  paterno varchar(150),
  nombre varchar(200),
  user_id bigint unsigned,
  foreign key(user_id) references users(id)
);

create table alumnos_on_tutores(
    id bigint unsigned  primary key auto_increment, 
    tutor_id bigint unsigned,
    foreign key(tutor_id) references tutores(id),
    alumno_id bigint unsigned,
    foreign key(alumno_id) references alumnos(id)
);


create table inscripciones(
    id bigint unsigned  primary key auto_increment, 
    alumno_id bigint unsigned,
    foreign key(alumno_id) references alumnos(id),
    grupo_id bigint unsigned,
    foreign key(grupo_id) references grupos(id),
    ciclo_id bigint unsigned,
    foreign key(ciclo_id) references ciclos(id),
    grado_id bigint unsigned,
    foreign key(grado_id) references grados(id)
);

create table clases(
    id bigint unsigned  primary key auto_increment, 
    profesor_id bigint unsigned,
    foreign key(profesor_id) references profesores(id),
    grupo_id bigint unsigned,
    foreign key(grupo_id) references grupos(id),
    ciclo_id bigint unsigned,
    foreign key(ciclo_id) references ciclos(id),
    grado_id bigint unsigned,
    foreign key(grado_id) references grados(id),
    materia_id bigint unsigned,
    foreign key(materia_id) references materias(id)
);

create table parciales(
    id bigint unsigned  primary key auto_increment,
    nombre varchar(150)
);

create table calificaciones(
    id bigint unsigned  primary key auto_increment, 
    calificacion float,
    clase_id bigint unsigned,
    foreign key(clase_id) references clases(id),
    alumno_id bigint unsigned,
    foreign key(alumno_id) references alumnos(id),
    parciales_id bigint unsigned,
    foreign key(parciales_id) references parciales(id)
);


create table calificaciones_finales(
    id bigint unsigned  primary key auto_increment, 
    calificacion float,
    clase_id bigint unsigned,
    foreign key(clase_id) references clases(id),
    alumno_id bigint unsigned,
    foreign key(alumno_id) references alumnos(id)
);


create table noticias(
    id bigint unsigned  primary key auto_increment, 
    title varchar(250),
    body text,
    img text
);



insert into ciclos(nombre, status) values ('2020B',1);
insert into grados(nombre) values ('1° Semestre'), ('2° Semestre'),('3° Semestre'), ('4° Semestre'), ('5° Semestre'), ('6° Semestre');
insert into grupos(nombre) values ('A'), ('B'),('C');
insert into grupos(nombre) values ('1'), ('2'),('3');

insert into materias(nombre, grado_id, plan) 
values('Español',1,'Reprehenderit aliqua tempor dolore aliqua occaecat. Dolore incididunt qui esse nulla id. Ipsum non esse et laboris. Laboris qui excepteur sit cupidatat proident officia in est enim. Exercitation magna ipsum consectetur nulla ad eiusmod tempor do do. Veniam qui dolor id anim quis.'),
('Matemáticas',1,"Duis enim consequat ea tempor id dolore aliqua culpa cillum occaecat ut minim duis magna. Deserunt cupidatat culpa id ea cupidatat. Sunt cillum sunt dolor nostrud fugiat cillum labore proident exercitation nostrud proident do. Et et adipisicing duis duis adipisicing ipsum elit proident voluptate cupidatat velit consequat in. Tempor elit ullamco est incididunt non commodo est incididunt sunt esse. Minim non sint deserunt labore commodo sit occaecat ipsum nostrud ea fugiat aliquip aliqua exercitation."), 
('Historia',1,"Mollit consectetur mollit quis duis exercitation velit anim in esse quis incididunt. Dolore exercitation in excepteur sint et ad pariatur aute ea amet nostrud velit. Sunt dolore anim consequat ea. Amet nisi elit laborum qui aliqua. Labore velit nostrud mollit laboris sint commodo fugiat quis consectetur."), 
('Inglés',1,"Nisi in proident occaecat amet. Non ullamco aliquip sint nisi ut culpa ex adipisicing eu nulla elit veniam. Velit anim magna incididunt adipisicing nisi sunt proident eiusmod fugiat nulla sunt nostrud non aute. Lorem reprehenderit elit dolore quis adipisicing ipsum consectetur minim. Voluptate ex fugiat veniam aute anim sunt.");

insert into alumnos(nombre,paterno,materno,user_id) values ('Jovanny','Ramírez','Chimal',1),('Valentín','Abundo','Hernandez',2);

insert into inscripciones(alumno_id, grado_id, grupo_id,ciclo_id) values(1,1,1,1),(2,1,1,1);



