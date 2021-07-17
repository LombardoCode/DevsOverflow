<?php

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

Route::get('/', function () {
	return view('inicio', [
		'titulo' => 'DevsOverflow'
	]);
});

Route::get('/registrarse', function () {
	return view('registrarse', [
		'titulo' => 'Registrarse'
	]);
});

Route::get('/login', function () {
	return view('login', [
		'titulo' => 'Iniciar sesión'
	]);
});

Route::prefix('api')->group(function() {
	Route::prefix('auth')->group(function() {
		Route::post('/register', [UserController::class, 'store']);
		Route::post('/login', [UserController::class, 'login']);
	});
});
