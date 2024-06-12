<?php

declare(strict_types=1);

namespace App\Routing;

enum EventRequirement
{
    public const NAME = '(\w|[- ])+';
    public const DATE = '\d{2}-\d{2}-\d{4}';
}
