<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testItCanCreateUser(): void
    {

        $userData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post('/register', $userData);

        $response->assertStatus(302);

        $this->assertDatabaseHas('users', ['email' => 'john.doe@example.com']);
    }

    public function testItCanAuthenticateUser(): void
    {
        $user = User::factory()->create([
            'email' => 'john.doe@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'john.doe@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $this->assertAuthenticatedAs($user);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PermissionSeeder::class);
    }

    public function testItCanCheckPermissions(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo('sites_view');

        $this->assertTrue($user->can('sites_view'));
    }
}
