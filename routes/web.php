<?php

use App\Http\Controllers\BusquedaController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\RespuestaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VotoController;
use Carbon\Carbon;
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
			'titulo' => 'Registrarse',
			'anio_actual' => Carbon::now()->format('Y')
		]);
	});
	Route::get('/login', function () {
		return view('login', [
			'titulo' => 'Iniciar sesión',
			'anio_actual' => Carbon::now()->format('Y')
		]);
	})->name('login');
});

/* Rutas públicas */
// Inicio
Route::get('/', [BusquedaController::class, 'mostrar_vista_inicio']);

// Búsqueda de preguntas
Route::prefix('busqueda')->group(function() {
	Route::get('/{query}', [BusquedaController::class, 'mostrar_vista_resultados']);
});

Route::prefix('pregunta')->group(function() {
	// Ruta protegida
	Route::group(['middleware' => 'api'], function() {
		// Vista para que los usuarios autenticados puedan crear preguntas
		Route::get('/crear', [PreguntaController::class, 'mostrar_vista_crear_pregunta']);
	});
	// Vista para mostrar la pregunta creada por un usuario
	Route::get('/{identificador_pregunta}', [PreguntaController::class, 'mostrar_vista_pregunta']);
});

Route::prefix('usuarios')->group(function() {
	// Vista para mostrar los usuarios
	Route::get('/', [UsuarioController::class, 'mostrar_vista_usuarios']);
	// Vista para mostrar un usuario en específico
	Route::get('/{usuario_id}', [UsuarioController::class, 'mostrar_vista_usuario_especifico']);
});

Route::prefix('categorias')->group(function() {
	Route::get('/', [CategoriaController::class, 'mostrar_vista_categorias']);
	Route::get('/{nombre_categoria}', [CategoriaController::class, 'mostrar_vista_preguntas_con_categoria']);
});

Route::prefix('sin-responder')->group(function() {
	Route::get('/', [BusquedaController::class, 'mostrar_vista_preguntas_sin_responder']);
});

/* API (web) */
Route::prefix('api')->group(function() {
	Route::prefix('auth')->group(function() {
		Route::post('/register', [AuthController::class, 'registrar_usuario']);
		Route::post('/login', [AuthController::class, 'login']);
	});
	Route::prefix('pregunta')->group(function() {
		Route::get('/{pregunta_id}', [PreguntaController::class, 'show']);
		Route::post('/', [PreguntaController::class, 'store']);
		Route::prefix('votar')->group(function() {
			Route::post('/', [VotoController::class, 'votar_pregunta']);
		});
	});
	Route::prefix('respuesta')->group(function() {
		Route::post('/', [RespuestaController::class, 'store']);
		Route::prefix('votar')->group(function() {
			Route::post('/', [VotoController::class, 'votar_respuesta']);
		});
	});
	Route::prefix('busqueda')->group(function() {
		Route::post('/', [BusquedaController::class, 'realizar_busqueda']);
		Route::prefix('categoria')->group(function() {
			Route::post('/', [CategoriaController::class, 'realizar_busqueda']);
		});
		Route::prefix('sin-responder')->group(function() {
			Route::post('/', [BusquedaController::class, 'realizar_busqueda_sin_responder']);
		});
	});
	Route::prefix('usuarios')->group(function() {
		Route::post('/', [UsuarioController::class, 'all']);
	});
	Route::prefix('categoria')->group(function() {
		Route::get('/{nombre_categoria}', [CategoriaController::class, 'show']);
		Route::post('/', [CategoriaController::class, 'all']);
	});
	Route::prefix('notificaciones')->group(function() {
		Route::get('/', [NotificacionController::class, 'all']);
	});
});
