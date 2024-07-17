<?php

namespace Tests\Feature;

use App\Models\Site;
use App\Models\Type;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SitesIndexTest extends TestCase
{
    use RefreshDatabase;

    public function testItCanViewListSites(): void
    {

        $this->withoutExceptionHandling();

        $type = Type::factory()->create();

        Site::factory()->create([
            'name' => 'Mi Comercio',
            'type_id' => $type->id,
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('site.index'));

        $response->assertOk();

        $response->assertViewIs('site.index');

        $response->assertViewHas('sites');

        $response->assertSee('Mi Comercio');

    }
    public function testAnUnauthenticatedUserCannotViewListSites(): void
    {
        Site::factory()
            ->for(Type::factory()->create())
            ->create([
                'name' => 'Mi Comercio'
            ]);

        $response = $this->get(route('site.index'));

        $response->assertRedirect(route('login'));
    }

}
