<?php

declare(strict_types=1);

namespace App\Event\Search;

final class ApiEventSearch implements EventSearchInterface
{
    public function searchByName(string|null $name = null): array
    {
        return [];
    }
}
