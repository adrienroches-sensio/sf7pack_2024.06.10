<?php

declare(strict_types=1);

namespace App\Security\Voter\Event;

use App\Entity\Event;
use App\Entity\User;
use App\Security\Permission;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class IsCreatorVoter implements VoterInterface
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

        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return self::ACCESS_ABSTAIN;
        }

        if (!$user instanceof User) {
            return self::ACCESS_ABSTAIN;
        }

        return $subject->getCreatedBy()->getId() === $user->getId() ? self::ACCESS_GRANTED : self::ACCESS_ABSTAIN;
    }
}
