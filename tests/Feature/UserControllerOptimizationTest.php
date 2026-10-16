<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class UserControllerOptimizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_queries()
    {
        // Setup some roles
        $adminRole = Role::create(['name' => 'admin']);
        $leadRole = Role::create(['name' => 'lead']);

        $team = Team::create(['name' => 'Test Team']);

        // Create an admin user
        $admin = User::factory()->create([
            'current_team_id' => $team->id,
        ]);
        $admin->assignRole('admin');

        // Create 20 users and assign roles
        for ($i = 0; $i < 20; $i++) {
            $user = User::factory()->create(['current_team_id' => $team->id]);
            $user->assignRole('lead');
        }

        DB::enableQueryLog();

        $response = $this->actingAs($admin)->get('/users');

        $response->assertStatus(200);

        $queries = DB::getQueryLog();
        $roleQueries = array_filter($queries, function ($query) {
            $sql = strtolower($query['query']);

            return str_contains($sql, 'model_has_roles') || str_contains($sql, 'roles');
        });

        $this->assertLessThanOrEqual(
            3,
            count($roleQueries),
            'Expected the users index to avoid N+1 role queries.'
        );
    }
}
