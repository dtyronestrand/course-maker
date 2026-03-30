<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Spatie\Permission\Models\Role;

class TestSeeder extends Seeder
{
    public function run()
    {
        // Add roles
        Role::create(['name' => 'lead']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'sme']);
        Role::create(['name' => 'designer']);
        Role::create(['name' => 'builder']);
        Role::create(['name' => 'id']);

        // Add dev cycle
        DB::table('development_cycles')->insert([
            'name' => 'Cycle 1',
            'start_date' => now(),
            'end_date' => now()->addMonths(6),
        ]);

        // Add a test user
        $user = User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('password123'),
        ]);

        // Give roles
        $user->assignRole('admin');

        // Add a course
        DB::table('courses')->insert([
            'prefix' => 'TEST',
            'number' => '101',
            'title' => 'Test Course 101',
            'development_cycle_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
