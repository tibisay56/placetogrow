<?php

namespace Tests\Feature;

use App\Models\Site;
use App\Models\Type;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateSiteTest extends TestCase
{
    use RefreshDatabase;

    public function testItCanViewSitesCreateForm(): void
    {

        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('site.create'));

        $response->assertOk();
        $response->assertViewIs('sites/create');
    }

    public function testItCanStoreASite(): void
    {
        $site = Site::factory()
            ->for(Type::factory()->create())
            ->make();
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('site.store'), $site->toArray());

        $response->assertRedirect(route('site.index'));

        $this->assertDatabaseHas('sites', [
            'name' => $site->name,
        ]);
    }

    public function testItCannotStoreASiteWithInvalidData(): void
    {
        $site = Site::factory()
            ->for(Type::factory()->create())
            ->make();
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('site.store'), $site->toArray());


        $this->assertDatabaseMissing('sites', [
            'name' => $site->name,
        ]);
    }
}

