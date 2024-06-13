<?php

declare(strict_types=1);

namespace App\EventDispatcher;

use App\Entity\Event as EventEntity;
use Symfony\Contracts\EventDispatcher\Event;

final class EventCreatedEvent extends Event
{
    public function __construct(public readonly EventEntity $event)
    {
    }
}
