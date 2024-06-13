<?php

declare(strict_types=1);

namespace App\Event\Search;

use App\Event\Client\ApiEventClient;
use App\Event\Client\TransformIntoDatabaseEntity;

final class ApiEventSearch implements EventSearchInterface
{
    public function __construct(
        private readonly ApiEventClient $client,
        private readonly TransformIntoDatabaseEntity $transformIntoDatabaseEntity,
    ) {
    }

    public function searchByName(string|null $name = null): array
    {
        return $this->transformIntoDatabaseEntity->transform(
            $this->client->searchByName($name)
        );
    }
}
