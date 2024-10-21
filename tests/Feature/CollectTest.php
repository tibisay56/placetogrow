<?php

namespace Tests\Feature;

use App\Constants\PaymentStatus;
use App\Models\Subscription;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CollectTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        Subscription::factory()->statusApproved()->create();
        Http::fake(['https://checkout-co.placetopay.dev/api/collect' => Http::response($this->collectResponseData())]);

        $this->artisan('app:collect')
            ->expectsOutput('Collect test data command executed')
            ->assertExitCode(0);

        $this->assertDatabaseHas(
            'payments',
            [
                'status' => PaymentStatus::APPROVED->value,
                'collect' => true,
            ]
        );
    }

    private function collectResponseData(): array
    {
        return [
            'requestId' => 1,
            'status' => [
                'status' => 'APPROVED',
                'reason' => '00',
                'message' => 'La petición ha sido aprobada exitosamente',
                'date' => '2021-11-30T15:49:47-05:00',
            ],
            'request' => [
                'locale' => 'es_CO',
                'payer' => [
                    'document' => '1033332222',
                    'documentType' => 'CC',
                    'name' => 'Name',
                    'surname' => 'LastName',
                    'email' => 'dnetix1@app.com',
                    'mobile' => '3111111111',
                    'address' => [
                        'postalCode' => '12345',
                    ],
                ],
                'payment' => [
                    'reference' => '1122334455',
                    'description' => 'Prueba',
                    'amount' => [
                        'currency' => 'USD',
                        'total' => 100,
                    ],
                    'allowPartial' => false,
                    'subscribe' => false,
                ],
                'returnUrl' => 'https://redirection.test/home',
                'ipAddress' => '127.0.0.1',
                'userAgent' => 'PlacetoPay Sandbox',
                'expiration' => '2021-12-30T00:00:00-05:00',
            ],
            'payment' => [
                [
                    'status' => [
                        'status' => 'APPROVED',
                        'reason' => '00',
                        'message' => 'Aprobada',
                        'date' => '2021-11-30T15:49:36-05:00',
                    ],
                    'internalReference' => 1,
                    'paymentMethod' => 'visa',
                    'paymentMethodName' => 'Visa',
                    'issuerName' => 'JPMORGAN CHASE BANK, N.A.',
                    'amount' => [
                        'from' => [
                            'currency' => 'USD',
                            'total' => 100,
                        ],
                        'to' => [
                            'currency' => 'USD',
                            'total' => 100,
                        ],
                        'factor' => 1,
                    ],
                    'authorization' => '000000',
                    'reference' => '1122334455',
                    'receipt' => '241516',
                    'franchise' => 'DF_VS',
                    'refunded' => false,
                    'processorFields' => [
                        [
                            'keyword' => 'lastDigits',
                            'value' => '1111',
                            'displayOn' => 'none',
                        ],
                    ],
                ],
            ],
            'subscription' => null,
        ];
    }
}
