<?php

declare(strict_types=1);

namespace App\Event\Client;

use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ApiEventClient
{
    public function __construct(
        private readonly HttpClientInterface $eventsClient,
    ) {
    }

    public function searchByName(string|null $name = null): array
    {
        return $this->eventsClient->request('GET', '/events', [
            'query' => ['name' => $name],
        ])->toArray();
    }
}
