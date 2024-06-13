<?php

declare(strict_types=1);

namespace App\Event\Search;

final class ChainedEventSearch implements EventSearchInterface
{
    public function __construct(
        private readonly EventSearchInterface $apiEventSearch,
        private readonly EventSearchInterface $databaseEventSearch,
    ) {
    }

    public function searchByName(?string $name = null): array
    {
        $this->apiEventSearch->searchByName($name);

        return $this->databaseEventSearch->searchByName($name);
    }
}
