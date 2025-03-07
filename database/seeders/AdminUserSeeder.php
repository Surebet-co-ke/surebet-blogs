<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create the admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'phone' => '1234567891',
            'password' => Hash::make('123456'), 
            'role' => 'admin', 
        ]);

        $this->command->info('Admin user created successfully!');
    }
}