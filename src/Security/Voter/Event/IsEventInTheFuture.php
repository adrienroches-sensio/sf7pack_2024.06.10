<?php

declare(strict_types=1);

namespace App\Security\Voter\Event;

use App\Entity\Event;
use App\Security\Permission;
use DateTimeImmutable;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class IsEventInTheFuture extends Voter
{
    protected function supports(string $attribute, mixed $subject): bool
    {
        return Permission::EVENT_EDIT === $attribute && $subject instanceof Event;
    }

    /**
     * @param Event $subject
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        return $subject->getStartAt() > new DateTimeImmutable('today');
    }
}
