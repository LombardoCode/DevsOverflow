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
	Route::group(['middleware' => 'auth'], function() {
		// Vista para que los usuarios autenticados puedan crear preguntas
		Route::get('/crear', [PreguntaController::class, 'mostrar_vista_crear_pregunta']);
	});
	Route::prefix('{identificador_pregunta}')->group(function() {
		// Vista para mostrar la pregunta creada por un usuario
		Route::get('/', [PreguntaController::class, 'mostrar_vista_pregunta']);
		Route::get('/editar', [PreguntaController::class, 'mostrar_vista_editar_pregunta']);
		Route::get('/eliminar', [PreguntaController::class, 'mostrar_vista_eliminar_pregunta']);
	});
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

Route::group(['middleware' => 'auth'], function() {
	Route::prefix('mis_preguntas')->group(function() {
		Route::get('/', [PreguntaController::class, 'mostrar_vista_mis_preguntas']);
	});
	Route::prefix('ajustes')->group(function() {
		Route::prefix('cuenta')->group(function() {
			Route::get('/', [UsuarioController::class, 'mostrar_vista_cuenta']);
		});
		Route::prefix('categorias')->group(function() {
			Route::get('/', [CategoriaController::class, 'mostrar_vista_mostrar_categorias']);
			Route::prefix('crear')->group(function() {
				Route::get('/', [CategoriaController::class, 'mostrar_vista_crear_categorias']);
			});
			Route::get('/{categoria_id}', [CategoriaController::class, 'mostrar_vista_editar_categoria']);
		});
	});

	Route::prefix('notificaciones')->group(function() {
		Route::get('/', [NotificacionController::class, 'mostrar_vista_notificaciones']);
	});
});

/* API (web) */
Route::prefix('api')->group(function() {
	Route::prefix('auth')->group(function() {
		Route::post('/register', [AuthController::class, 'registrar_usuario']);
		Route::post('/login', [AuthController::class, 'login']);
		Route::post('/logout', [AuthController::class, 'cerrar_sesion']);
	});
	Route::prefix('usuario')->group(function() {
		Route::put('/', [UsuarioController::class, 'update']);
	});
	Route::prefix('pregunta')->group(function() {
		Route::get('/{pregunta_id}', [PreguntaController::class, 'show']);
		Route::post('/', [PreguntaController::class, 'store']);
		Route::delete('/{pregunta_id}', [PreguntaController::class, 'delete']);
		Route::put('/{pregunta_id}', [PreguntaController::class, 'update']);
		Route::prefix('votar')->group(function() {
			Route::post('/', [VotoController::class, 'votar_pregunta']);
		});
	});
	Route::prefix('respuesta')->group(function() {
		Route::post('/', [RespuestaController::class, 'store']);
		Route::delete('/{respuesta_id}', [RespuestaController::class, 'delete']);
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
		Route::post('/obtener', [CategoriaController::class, 'show']);
		Route::post('/obtener_categorias', [CategoriaController::class, 'obtener_categorias']);
		Route::post('/', [CategoriaController::class, 'store']);
		Route::delete('/{categoria_id}', [CategoriaController::class, 'delete']);
		Route::put('/{categoria_id}', [CategoriaController::class, 'update']);
	});
	Route::prefix('notificaciones')->group(function() {
		Route::get('/', [NotificacionController::class, 'all']);
		Route::delete('/{notificacion_id}', [NotificacionController::class, 'delete']);
		Route::prefix('leer')->group(function() {
			Route::get('/{notificacion_id}', [NotificacionController::class, 'leer_notificacion']);
		});
		Route::prefix('historicas')->group(function() {
			Route::post('/', [NotificacionController::class, 'notificaciones_historicas']);
		});
	});
});
