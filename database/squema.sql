drop TABLE if EXISTS ciclos;
drop TABLE if EXISTS materias;
drop TABLE if EXISTS grupos;
drop TABLE if EXISTS grados;
drop TABLE if EXISTS alumnos;


create table ciclos(
    id bigint unsigned primary key auto_increment,
    nombre varchar(200),
    status enum('activo','no') default 'no'
);



create table grados(
    id bigint unsigned primary key auto_increment,
    nombre varchar(200)
);

create table materias(
    id bigint unsigned primary key auto_increment,
    nombre varchar(200),
    plan text,
    grado_id bigint unsigned,
    foreign key(grado_id) references grados(id)
);

create table grupos(
    id bigint unsigned primary key auto_increment,
    nombre varchar(200)
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

create table calificaciones(
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



