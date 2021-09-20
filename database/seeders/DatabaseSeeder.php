<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
			$u = new User();
			$u->name = "Lombardo";
			$u->email = "l@l.com";
			$u->password = bcrypt("l");
			$u->description = "Una descripción para Lombardo";
			$u->save();

			Role::create(['name' => 'administrador']);
			Permission::create(['name' => 'crear-categorias']);
			$u->assignRole('administrador');
			$u->givePermissionTo('crear-categorias');

			$faker = \Faker\Factory::create();
			for ($i=0; $i < 100; $i++) {
				User::create([
					'name' => $faker->name,
					'email' => $faker->email,
					'description' => $faker->text,
					'password' => bcrypt("12341234")
				]);
			}

			$categorias = array(
				0 => [
					'categoria' => 'Laravel',
					'descripcion' => 'PHP Framework for Web Artisans'
				],
				1 => [
					'categoria' => 'Vue.js',
					'descripcion' => 'The Progressive JavaScript Framework'
				],
				2 => [
					'categoria' => 'Bootstrap',
					'descripcion' => 'Bootstrap CSS Framework'
				],
				3 => [
					'categoria' => 'React.js',
					'descripcion' => 'React.js JavaScript Framework'
				],
				4 => [
					'categoria' => 'Angular.js',
					'descripcion' => 'Angular.js JavaScript Framework'
				],
				5 => [
					'categoria' => 'PHP',
					'descripcion' => 'PHP - Programming Language'
				],
				6 => [
					'categoria' => 'JavaScript',
					'descripcion' => 'JavaScript - Programming Language'
				],
				7 => [
					'categoria' => 'C++',
					'descripcion' => 'C++ - Programming Language'
				],
				8 => [
					'categoria' => 'Java',
					'descripcion' => 'Java - Programming Language'
				],
				9 => [
					'categoria' => 'Tailwind',
					'descripcion' => 'Tailwind CSS Framework'
				],
				10 => [
					'categoria' => 'Linux',
					'descripcion' => 'Linux'
				],
				11 => [
					'categoria' => 'GDScript',
					'descripcion' => "Godot's programming language"
				],
				12 => [
					'categoria' => 'SQL',
					'descripcion' => 'Structured Query Language'
				],
				13 => [
					'categoria' => 'jQuery',
					'descripcion' => 'JavaScript Framework'
				],
				14 => [
					'categoria' => 'Python',
					'descripcion' => 'Python - Programming Language'
				],
				15 => [
					'categoria' => 'Git',
					'descripcion' => 'Version control system'
				],
			);

			for ($i = 0; $i < count($categorias); $i++) {
				Categoria::create([
					'categoria' => $categorias[$i]['categoria'],
					'descripcion' => $categorias[$i]['descripcion'],
				]);
			}
    }
	}
