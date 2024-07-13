<?php

namespace Database\Seeders;

use App\Models\User;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!User::where('email', 'luis@petiko.com.br')-> first())
        {
            User::create([
                'name' =>'Luis',
                'email' => 'luis@petiko.com.br',
                'password' => Hash:: make('123456', ['rounds' =>10]),
                'is_admin' => true
            ]);
        }
    }
}
