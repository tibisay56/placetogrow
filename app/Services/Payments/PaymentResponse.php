<?php

namespace App\Services\Payments;

readonly class PaymentResponse
{
    public function __construct(
        public int $processIdentifier,
        public string $url,
    ) {
    }

    public function toArray(): array
    {
        return [
            'url' => $this->url,
            'process_Identifier' => $this->processIdentifier,
        ];
    }
}
