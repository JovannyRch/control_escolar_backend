<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AlumnoController;
use App\Http\Controllers\Api\ApreciacionesController;
use App\Http\Controllers\Api\CiclosController;
use App\Http\Controllers\Api\ClasesController;
use App\Http\Controllers\Api\GradosController;
use App\Http\Controllers\Api\GruposController;
use App\Http\Controllers\Api\MateriaController;
use App\Http\Controllers\Api\TutoresController;
use App\Http\Controllers\Api\ParcialesController;
use App\Http\Controllers\Api\ProfesoresController;
use App\Http\Controllers\Api\AsistenciasController;
use App\Http\Controllers\Api\InscripcionesController;
use App\Http\Controllers\Api\NoticiasController;
use App\Http\Controllers\Api\RespuestasApreciacionesController;

Route::group(['prefix' => 'auth','middleware' => ['cors', 'json.response'],], function () {
    Route::post('login', [UserController::class, 'login']);
    Route::post('register', [UserController::class, 'register']);
    

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', [UserController::class, 'logout']);
        Route::get('user',  [UserController::class, 'user']);       
        Route::post('updatePassword/{id}', [UserController::class, 'updatePassword']);
    });
});





Route::group(['middleware' => ['auth:api']], function () {
    //Users
    Route::get('materias/{id}',  [MateriaController::class, 'show']);
    Route::get('grupos/{grupo_id}/alumnos',[GruposController::class, 'alumnos']);

   

});

// Rutas de alumnos 'prefix' => 'auth'
Route::middleware(['auth:api','api.alumno'])->group(function () {
    
    Route::get('alumno/clases',  [AlumnoController::class, 'materiasConPromediosFinales']);
    Route::get('alumno/clases/{id}/details',  [AlumnoController::class, 'claseDetail']);
    Route::get('alumno/profesores',  [AlumnoController::class, 'profesoresConMaterias']);

    Route::get('alumno/noticias',[NoticiasController::class, 'index']);
    Route::get('alumno/noticias/{id}',[NoticiasController::class, 'show']);

    //Apreciaciones
    Route::get('alumno/apreciaciones/activo',[ApreciacionesController::class, 'apreciacionActiva']);
    Route::get('alumno/apreciaciones/{id}/preguntas',[ApreciacionesController::class, 'preguntas']);

    
});


// Rutas de profesores
Route::group(['prefix' => 'profesores','middleware' => ['auth:api', 'api.profesor'],], function () {
    Route::get('materias',  [ProfesoresController::class, 'materias']);
    Route::get('materias/{id}/grupos',  [ProfesoresController::class, 'gruposPorMateria']);
    
    Route::get('asistencia',[AsistenciasController::class, 'create']);
});

// Rutas de tutores
Route::middleware(['auth:api','api.tutor'])->group(function () {
    Route::get('tutor/{id}/tutorados',[TutoresController::class, 'tutorados']); //Es la misma que la del administrador
});


//Rutas del administrador
Route::middleware(['auth:api','api.admin'])->group(function () {
    Route::post('users',  [AdminController::class, 'createUser']);
    Route::get('alumnos',  [AdminController::class, 'cargarAlumnos']);
    Route::get('profesores',  [AdminController::class, 'cargarProfesores']);
    Route::get('tutores',  [AdminController::class, 'cargarTutores']);
    Route::delete('users/{id}',  [AdminController::class, 'deleteUser']);

    //Ciclos
    Route::get('ciclos',[CiclosController::class, 'index']);
    Route::post('ciclos',[CiclosController::class, 'crear']);
    Route::delete('ciclos/{id}',[CiclosController::class, 'eliminar']);
    Route::put('ciclos/{id}',[CiclosController::class, 'update']);
    Route::post('ciclos/activar/{id}',[CiclosController::class, 'activar']);

    //Grupos
    Route::get('grupos',[GruposController::class, 'index']);
    Route::post('grupos',[GruposController::class, 'create']);
    Route::put('grupos/{id}',[GruposController::class, 'update']);
    Route::delete('grupos/{id}',[GruposController::class, 'delete']);

    //Grados
    Route::get('grados',[GradosController::class, 'index']);
    Route::get('grados/{id}',[GradosController::class, 'show']);
    Route::post('grados',[GradosController::class, 'create']);
    Route::put('grados/{id}',[GradosController::class, 'update']);
    Route::delete('grados/{id}',[GradosController::class, 'delete']);


    //Materias
    Route::get('materias',[MateriaController::class, 'index']);
    Route::get('materias/{id}',[MateriaController::class, 'show']);
    Route::post('materias',[MateriaController::class, 'create']);
    Route::put('materias/{id}',[MateriaController::class, 'update']);
    Route::delete('materias/{id}',[MateriaController::class, 'delete']);

    //Materias por grado
    Route::get('grados/{id}/materias',[GradosController::class, 'materias']);

    //Tutores
    Route::post('tutor/alumno',[TutoresController::class, 'agregarAlumno']); 
    Route::get('tutor/{id}/tutorados',[TutoresController::class, 'tutorados']);
    Route::delete('tutor/tutorado/{id}',[TutoresController::class, 'deleteTutorado']);

    //Clases
    Route::get('clases',[ClasesController::class, 'index']);
    Route::post('clases',[ClasesController::class, 'create']);
    Route::delete('clases/{id}',[ClasesController::class, 'delete']);
    
    //Parciales
    Route::get('parciales',[ParcialesController::class, 'index']);
    Route::post('parciales',[ParcialesController::class, 'create']);
    Route::delete('parciales/{id}',[ParcialesController::class, 'delete']);
    Route::put('parciales/{id}',[ParcialesController::class, 'update']);

    //Noticias
    Route::get('noticias',[NoticiasController::class, 'index']);
    Route::get('noticias/{id}',[NoticiasController::class, 'show']);
    Route::post('noticias',[NoticiasController::class, 'create']);
    Route::delete('noticias/{id}',[NoticiasController::class, 'delete']);
    Route::put('noticias/{id}',[NoticiasController::class, 'update']);

    //Inscripciones
    Route::get('inscripciones',[InscripcionesController::class, 'index']);
    Route::get('inscripciones/{id}',[InscripcionesController::class, 'show']);
    Route::post('inscripciones',[InscripcionesController::class, 'create']);
    Route::delete('inscripciones/{id}',[InscripcionesController::class, 'delete']);
    Route::put('inscripciones/{id}',[InscripcionesController::class, 'update']);

    //Apreciaciones
    Route::get('apreciaciones',[ApreciacionesController::class, 'index']);
    Route::get('apreciaciones/{id}',[ApreciacionesController::class, 'show']);
    Route::post('apreciaciones',[ApreciacionesController::class, 'create']);
    Route::delete('apreciaciones/{id}',[ApreciacionesController::class, 'delete']);
    Route::put('apreciaciones/{id}',[ApreciacionesController::class, 'update']);

    //Preguntas de las apreciaciones
    Route::get('apreciaciones/{id}/preguntas',[ApreciacionesController::class, 'preguntas']);
    Route::post('apreciaciones/preguntas',[ApreciacionesController::class, 'createPregunta']);
    Route::put('apreciaciones/preguntas/{id}',[ApreciacionesController::class, 'updatePregunta']);
    Route::delete('apreciaciones/preguntas/{id}',[ApreciacionesController::class, 'deletePregunta']);
    Route::delete('preguntas/{id}/respuestas',[RespuestasApreciacionesController::class, 'showByPregunta']);
});


