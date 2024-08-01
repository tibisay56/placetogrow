<?php

namespace Tests\Feature\Payments;

use App\Constants\CurrencyType;
use App\Constants\DocumentTypes;
use App\Constants\PaymentGateway;
use App\Constants\PaymentStatus;
use App\Models\Site;
use App\Models\Type;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class StorePaymentTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * A basic feature test example.
     */
    public function testStorePaymentSuccessfully(): void
    {
        $this->withoutExceptionHandling();

        $responseData = [
            'status' => [
                'status' => 'OK',
                'reason' => 'PC',
                'message' => 'Respuesta falsa',
                'date' => '2021-11-30T15:08:27-05:00',
            ],
            'requestId' => 1,
            'processUrl' => 'https://checkout-co.placetopay.com/session/1/cc9b8690b1f7228c78b759ce27d7e80a',
        ];

        Http::fake(fn (Request $request) => Http::response($responseData, 200));

        Type::factory()->create();
        $site = Site::factory()->create();
        $user = User::factory()->create();

        $data = [
            'description' => fake()->sentence(),
            'amount' => 10000,
            'site_id' => $site->id,
            'currency' => CurrencyType::USD->name,
            'name' => 'Jhon',
            'lastname' => 'Doe',
            'email' => fake()->freeEmail(),
            'document_number' => 4444444,
            'document_type' => DocumentTypes::CC->name,
            'gateway' => PaymentGateway::PLACETOPAY->value,
        ];

        $response = $this->actingAs($user)->post(route('payment.store'), $data);

        $response->assertSessionHasNoErrors()
            ->assertRedirect($responseData['processUrl']);

        $this->assertDatabaseHas('payments', [
            'site_id' => $site->id,
            'description' => $data['description'],
            'amount' => 10000,
            'gateway' => PaymentGateway::PLACETOPAY->value,
            'status' => PaymentStatus::PENDING->value,
            'process_identifier' => $responseData['requestId'],
        ]);
    }
}
