<?php

use App\Http\Controllers\BusquedaController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Rutas para usuarios invitados (no autenticados)
Route::group(['middleware' => ['guest']], function() {
	Route::get('/registrarse', function () {
		return view('registrarse', [
			'titulo' => 'Registrarse'
		]);
	});
	Route::get('/login', function () {
		return view('login', [
			'titulo' => 'Iniciar sesión'
		]);
	})->name('login');
});

/* Rutas públicas */
// Inicio
Route::get('/', function () {
	return view('inicio', [
		'titulo' => 'DevsOverflow'
	]);
});

// Búsqueda de preguntas
Route::prefix('busqueda')->group(function() {
	Route::get('/{query}', [BusquedaController::class, 'realizar_busqueda']);
});


/* Rutas protegidas */
Route::group(['middleware' => 'api'], function() {
	// Preguntas
	Route::prefix('pregunta')->group(function() {
		// Vista para que los usuarios autenticados puedan crear preguntas
		Route::get('/crear', [PreguntaController::class, 'mostrar_vista_crear_pregunta']);
		// Vista para mostrar la pregunta creada por un usuario
		Route::get('/{identificador_pregunta}', [PreguntaController::class, 'mostrar_vista_pregunta']);
	});
});

/* API (web) */
Route::prefix('api')->group(function() {
	Route::prefix('auth')->group(function() {
		Route::post('/register', [UserController::class, 'registrar_usuario']);
		Route::post('/login', [UserController::class, 'login']);
	});
	Route::prefix('pregunta')->group(function() {
		Route::post('/', [PreguntaController::class, 'store']);
	});
});
