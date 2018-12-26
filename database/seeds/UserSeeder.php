<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name'=>'Mr.',
            'last_name'=>' Admin',
            'password'=>Hash::make("123456"),
            'email'=>'admin@email.com',
            'role'=>1,
            'active_status'=>1,
            'email_verified'=>1,
            'reset_code' => md5('admin@email.com' . uniqid() . randomString(5)),
        ]);

        User::create([
            'first_name'=>'Mr.',
            'last_name'=>' User',
            'password'=>Hash::make("123456"),
            'email'=>'user@email.com',
            'role'=>2,
            'active_status'=>1,
            'email_verified'=>1,
            'reset_code' => md5('user@email.com' . uniqid() . randomString(5)),

        ]);
    }
}
