<?php

namespace Tests\Feature;

use App\Models\Site;
use App\Models\Type;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class SiteTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed');
    }

    public function an_admin_can_view_sites()
    {

        $user = User::factory()->create();
        $user->assignRole('Admin');

        $site = Site::factory()->create([
            'name' => 'Test Site',
        ]);

        $response = $this->actingAs($user)->get(route('site.index'));

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Site/Index')
                ->has('sites', 12)
            );
    }

    public function a_user_can_create_a_site()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');

        $type = Type::factory()->create();

        $response = $this->actingAs($user)->post(route('site.store'), [
            'name' => 'New Site',
            'type_id' => $type->id,
            'category' => 'Category',
            'currency' => 'USD',
            'payment_expiration_time' => 120,
            'avatar' => null,
        ]);

        $response->assertRedirect(route('site.index'));
        $this->assertDatabaseHas('sites', ['name' => 'New Site']);
    }

    public function an_admin_can_view_the_edit_form_for_a_site()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');

        $site = Site::factory()->create();

        $response = $this->actingAs($user)->get(route('site.edit', $site->slug));

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Site/Edit')
                ->where('site.name', $site->name)
            );
    }


    public function an_admin_can_update_a_site()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');

        $site = Site::factory()->create();

        $response = $this->actingAs($user)->post(route('site.update', $site->slug), [
            'name' => 'Updated Site Name',
            'type_id' => $site->type_id,
            'category' => 'Updated Category',
            'currency' => 'COP',
            'payment_expiration_time' => 180,
        ]);

        $response->assertRedirect(route('site.index'));
        $this->assertDatabaseHas('sites', ['name' => 'Updated Site Name']);
    }

    public function an_admin_can_delete_a_site()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');

        $site = Site::factory()->create();

        $response = $this->actingAs($user)->delete(route('site.destroy', $site->slug));

        $response->assertRedirect(route('site.index'));
        $this->assertDatabaseMissing('sites', ['id' => $site->id]);
    }
}

