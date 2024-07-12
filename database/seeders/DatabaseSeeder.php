<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    // public function run()
    // {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            JilidSeeder::class,
            KamarSeeder::class,
            MapelSeeder::class,
            KelasMadinSeeder::class,
            KelasSeeder::class,
            RolePermissionSeeder::class,
        ]);

        $users = User::create([
            'name' => 'Admin PPM Al-Azhar',
            'username' => 'admin',
            'password' => Hash::make('admin'), // Pastikan untuk menghash password
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $users->assignRole('admin');
    }
    // }
}
