<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; //them cai nay

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = [
            [
                'name'=>'Admin User',
                'email'=>'admin@gmail.com',
                'role'=>2,
                'password'=> bcrypt('123456'),
                'type_login'=>0,
            ],
            [
                'name'=>'Employee User',
                'email'=>'seller@gmail.com',
                'role'=> 1,
                'password'=> bcrypt('123456'),
                'type_login'=>0,
            ],
            [
                'name'=>'User',
                'email'=>'user@gmail.com',
                'role'=>0,
                'password'=> bcrypt('123456'),
                'type_login'=>0,
            ],
        ];

        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
