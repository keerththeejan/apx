<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'admin@example.com';
        $password = 'Admin@12345';

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Admin',
                'password' => Hash::make($password),
                'is_admin' => true,
            ]
        );

        // Ensure promoted if user already existed
        if (!$user->is_admin) {
            $user->is_admin = true;
        }
        // Ensure password is set to the known value for local setup
        $user->password = Hash::make($password);
        $user->save();
    }
}
