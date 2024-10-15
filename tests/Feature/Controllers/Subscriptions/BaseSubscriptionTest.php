<?php

namespace Tests\Feature\Controllers\Subscriptions;

use App\Constants\SubscriptionStatus;
use App\Models\Site;
use App\Models\Subscription;
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

    public function test_return_and_store_token()
    {
        $type = Type::factory()->create([
            'id' => 3,
            'name' => 'subscriptions',
        ]);

        $subscriptions = Subscription::factory()->create([
            'request_id' => '3',
            'type_id' => $type->id,
        ]);

        $this->getJson(route('subscription.return', $subscriptions))->assertOk();

        $this->assertDatabaseHas('subscription', [
            'site_id' => $subscriptions->site_id,
            'request_id' => '1',
            'token' => $subscriptions->token,
            'sub_token' => $subscriptions->sub_token,
        ]);
    }
}
