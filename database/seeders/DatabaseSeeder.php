<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        User::factory(3)->create()->each(fn($user) => $user->assignRole('lead'));
        User::factory(20)->create()->each(fn($user) => $user->assignRole(['id', 'sme'][rand(0, 1)]));

       
    }
}
