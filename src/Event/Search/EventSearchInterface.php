<?php

declare(strict_types=1);

namespace App\Event\Search;

use App\Entity\Event;

interface EventSearchInterface
{
    /**
     * @return list<Event>
     */
    public function searchByName(?string $name = null): array;
}
