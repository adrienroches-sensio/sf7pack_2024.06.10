<?php

declare(strict_types=1);

namespace App\Security\Voter\Event;

use App\Entity\Event;
use App\Entity\User;
use App\Security\Permission;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class IsCreatorVoter extends Voter
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
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        if (!$user instanceof User) {
            return false;
        }

        return $subject->getCreatedBy()->getId() === $user->getId();
    }
}
