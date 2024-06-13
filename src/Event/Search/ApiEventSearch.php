<?php

declare(strict_types=1);

namespace App\Event\Search;

use Symfony\Component\HttpClient\HttpClient;

final class ApiEventSearch implements EventSearchInterface
{
    public function __construct(
        private readonly string $eventsApiKey,
    ) {
    }

    public function searchByName(string|null $name = null): array
    {
        $client = HttpClient::create();

        return $client->request('GET', 'https://www.devevents-api.fr/api/events', [
            'query' => ['name' => $name],
            'headers' => [
                'apikey' => $this->eventsApiKey,
                'Accept' => 'application/json',
            ],
        ])->toArray();
    }
}
