<?php

declare(strict_types=1);

namespace App\Security\Voter\Event;

use App\Entity\Event;
use App\Security\Permission;
use DateTimeImmutable;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

final class IsEventInTheFuture implements VoterInterface
{
    /**
     * @param Event $subject
     */
    public function vote(TokenInterface $token, mixed $subject, array $attributes): int
    {
        $attribute = $attributes[0];

        if ($attribute !== Permission::EVENT_EDIT || !$subject instanceof Event) {
            return self::ACCESS_ABSTAIN;
        }

        return $subject->getStartAt() > new DateTimeImmutable('today') ? self::ACCESS_ABSTAIN : self::ACCESS_DENIED;
    }
}
