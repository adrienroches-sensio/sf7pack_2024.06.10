<?php

declare(strict_types=1);

namespace App\EventDispatcher;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

final class EventListener
{
    #[AsEventListener]
    public function sendMailToAdmins(EventCreatedEvent $event): void
    {
        dump($event);
    }
}
