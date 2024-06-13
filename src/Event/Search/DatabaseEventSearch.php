<?php

declare(strict_types=1);

namespace App\Event\Search;

use App\Repository\EventRepository;

final class DatabaseEventSearch implements EventSearchInterface
{
    public function __construct(
        private readonly EventRepository $eventRepository,
        private readonly int $maxResult,
    ) {
    }

    public function searchByName(string|null $name = null): array
    {
        if (null === $name) {
            return $this->eventRepository->list();
        }

        return $this->eventRepository->searchByName($name);
    }
}
