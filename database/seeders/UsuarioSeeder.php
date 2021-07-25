<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
			$faker = \Faker\Factory::create();
			for ($i=0; $i < 100; $i++) {
				User::create([
					'name' => $faker->name,
					'email' => $faker->email,
					'description' => $faker->text,
					'password' => bcrypt("12341234")
				]);
			}
    }
}
