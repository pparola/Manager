<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
   public function run()
   {

      App\User::truncate();

		App\User::Create([
			'name'           => 'Pablo Parola',
			'email'          => 'p.parola@gmail.com',
			'password'       => bcrypt('123456'),
         'CATEGORIA'      => 1,
		]);

   }
}
