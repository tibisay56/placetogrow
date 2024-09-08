<?php

namespace Tests\Feature\Controllers\Subscriptions;

use App\Constants\SubscriptionStatus;
use App\Models\Site;
use App\Models\Type;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BaseSubscriptionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        Type::firstOrCreate(['name' => 'subscriptions']);
    }

    public function test_example(): void
    {
        $site = Site::factory()->create();

        $this->postJson(route('subscriptions.store', $site), [
            'reference' => 'test_reference',
            'email' => 'jhon@doe.com',
            'plan' => [
                'price' => '10000',
                'months' => 3,
            ],
        ])->assertRedirect('http://localhost');

        $this->assertDatabaseHas('users', ['email' => 'jhon@doe.com']);

        $this->assertDatabaseHas('subscriptions', [
            'site_id' => $site->id,
            'request_id' => '1',
            'status' => SubscriptionStatus::PENDING->value,
            'price' => '10.000',
        ]);
    }
}
