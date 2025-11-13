<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin rolü var mı kontrol et, yoksa oluştur
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Ana kullanıcı oluştur
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'), // şifre: password
            ]
        );

        // Role ata
        $admin->assignRole($adminRole);

        echo "✅ Admin user created: admin@example.com / password\n";
    }
}
