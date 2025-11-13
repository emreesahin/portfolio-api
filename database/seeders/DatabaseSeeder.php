<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ✅ Seeder çağrıları (önemli olan sırayla)
        $this->call([
            RoleSeeder::class,  
            UserSeeder::class,  
            AboutSeeder::class,

        ]);
    }
}
