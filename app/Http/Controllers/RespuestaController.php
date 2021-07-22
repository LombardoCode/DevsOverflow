<?php

namespace App\Http\Controllers;

use App\Models\Respuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RespuestaController extends Controller
{
	public function store(Request $request) {
		$reglas = [
			'contenido_html' => 'required'
		];

		$erroresPersonalizados = [
			'contenido_html.required' => 'Se requiere del cuerpo de la pregunta'
		];

		$validaciones = Validator::make($request->all(), $reglas, $erroresPersonalizados);

		if ($validaciones->fails()) {
			return redirect()->back()->withErrors($validaciones)->withInput();
		} else {
			$respuesta = new Respuesta([
				'user_id' => Auth::user()->id,
				'pregunta_id' => $request['pregunta_id'],
				'contenido_html' => $request['contenido_html'],
				'mejor_respuesta' => 0
			]);

			if ($respuesta->save()) {
				$respuesta['autor'] = Auth::user()->name;
				return response()->json([
					'status' => true,
					'respuesta' => $respuesta
				]);
			}
		}
	}
}
