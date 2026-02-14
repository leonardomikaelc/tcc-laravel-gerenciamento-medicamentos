<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run()
    {

        $email = 'leonardo@gmail.com';

        $exists = DB::table('users')->where('email', $email)->exists();

        if (!$exists) {
            DB::table('users')->insert([
                'name' => 'Administrador',
                'email' => $email,
                'email_verified_at' => now(),
                'password' => Hash::make('leo12345'),
                'role' => 'admin',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
