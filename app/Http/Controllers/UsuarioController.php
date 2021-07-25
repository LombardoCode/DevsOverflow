<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
	public function mostrar_vista_usuarios() {
		return view('mostrar_usuarios', [
			'titulo' => 'Usuarios'
		]);
	}

	public function mostrar_vista_usuario_especifico($usuario_id) {
		// Buscamos al usuario
		$usuario = User::find($usuario_id);

		if (isset($usuario->id)) {
			return view('mostrar_usuario', [
				'status' => true,
				'titulo' => 'Usuario',
				'usuario' => $usuario
			]);
		} else {
			return view('mostrar_usuario', [
				'status' => false,
				'titulo' => 'Usuario no encontrado',
			]);
		}
	}

	public function all(Request $request) {
		$filtro = $request['filtro'];
		$itemsMaxPorPag = $request['itemsMaxPorPag'];
		$offset = ((($request['pagina'] + 1) - 1) * $itemsMaxPorPag);
		$cantidad_de_usuarios = null;
		$usuarios = [];

		if ($filtro == 'todos') {
			$usuarios = DB::table('users')
			->orderBy('created_at', 'asc')
			->offset($offset)
			->limit($itemsMaxPorPag)
			->get();
		} else {
			if ($filtro == 'nuevos_usuarios') {
				$usuarios = DB::table('users')
				->orderBy('created_at', 'desc')
				->offset($offset)
				->limit($itemsMaxPorPag)
				->get();
			}
		}

		$cantidad_de_usuarios = DB::table('users')
		->orderBy('created_at', 'asc')
		->count();

		return response()->json([
			'status' => true,
			'usuarios' => $usuarios,
			'cantidad_de_usuarios' => $cantidad_de_usuarios
		]);
	}
}
