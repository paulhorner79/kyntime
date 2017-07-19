<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();
        if (!$user) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@kyntime.com',
                'password' => bcrypt('change.me')
            ]);
        }
    }
}
