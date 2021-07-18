<?php

namespace App\Http\Controllers;

use App\Models\Pregunta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PreguntaController extends Controller
{
	public function mostrar_vista_crear_pregunta() {
		return view('auth.crear_pregunta', [
			'titulo' => 'Crear pregunta'
		]);
	}

	public function store(Request $request) {
		$reglas = [
			'titulo' => 'required',
			'contenido_html' => 'required'
		];

		$erroresPersonalizados = [
			'titulo.required' => 'Se requiere de un título para la pregunta.',
			'contenido_html.required' => 'Se requiere del cuerpo de la pregunta'
		];

		$validaciones = Validator::make($request->all(), $reglas, $erroresPersonalizados);

		if ($validaciones->fails()) {
			return redirect()->back()->withErrors($validaciones)->withInput();
		} else {
			$identificador_aleatorio = $this->generarIdentificador(16);

			$resumen_pregunta = strip_tags($request['pregunta_html']);
			$pregunta = new Pregunta([
				'user_id' => Auth::user()->id,
				'pregunta' => $request['titulo'],
				'contenido_html' => $request['contenido_html'],
				'resumen' => $resumen_pregunta,
				'identificador' => $identificador_aleatorio
			]);

			if ($pregunta->save()) {
				return redirect('/pregunta/'.$identificador_aleatorio);
			}
		}
	}

	public function generarIdentificador($cantidad_caracteres) {
		return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($cantidad_caracteres/strlen($x)) )),1,$cantidad_caracteres);
	}

	public function mostrar_vista_pregunta($identificador_pregunta) {
		$pregunta = Pregunta::where('identificador', '=', $identificador_pregunta)->get()[0];

		if ($pregunta) {
			return view('auth.mostrar_pregunta', [
				'titulo' => $pregunta['pregunta'],
				'pregunta_encontrada' => true,
				'pregunta' => $pregunta
			]);
		} else {
			return view('auth.mostrar_pregunta', [
				'titulo' => 'Pregunta no encontrada',
				'pregunta_encontrada' => false,
			]);
		}
	}
}
