<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB:: table('users')->insert(array(
            'name' =>'Usuario',
            'email'=>'usuario@gmail.com',
            'password'=>\Hash::make('usuario'),
            'telefono'=>'71255896',
            'avatar' =>'user_default.png',
            'active' =>'1',
        	));
    }
}
