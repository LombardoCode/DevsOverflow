<?php

namespace App\Http\Controllers;

use App\Models\Pregunta;
use App\Models\Respuesta;
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
			// Obtenemos las últimas 5 preguntas realizadas por el usuario
			$preguntas = Pregunta::where('user_id', '=', $usuario->id)
			->offset(0)
			->limit(5)
			->orderBy('created_at', 'ASC')
			->get();

			// Obtenemos las últimas 5 preguntas las cuales fueron contestadas por el usuario
			$respuestas = Respuesta::where('user_id', '=', $usuario->id)
			->offset(0)
			->limit(5)
			->groupBy('pregunta_id')
			->orderBy('created_at', 'ASC')
			->get();

			$preguntas_contestadas = [];

			for ($i=0; $i < count($respuestas); $i++) {
				$pregunta = Pregunta::find($respuestas[$i]['pregunta_id']);
				$preguntas_contestadas[] = $pregunta;
			}

			return view('mostrar_usuario', [
				'status' => true,
				'titulo' => 'Perfil - ' . $usuario->name,
				'usuario' => $usuario,
				'preguntas' => $preguntas,
				'preguntas_contestadas' => $preguntas_contestadas
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
