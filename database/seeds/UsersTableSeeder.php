<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// Тестовая запись для проверки работы
    	User::insert([
            'name' => 'Admin',
            'email' => 'admin@test.loc',
            'password' => bcrypt('password'),
        ]);

        // Создаем еще 15 случайных пользователей
        factory(App\User::class, 15)->create();
    }
}
