<?php

namespace App\Security\Voter;

use App\Entity\Event;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class EventVoter extends Voter
{
    public const EDIT = 'EVENT_EDIT';

    public function __construct(
        private readonly AuthorizationCheckerInterface $authorizationChecker,
    ) {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return self::EDIT === $attribute && $subject instanceof Event;
    }

    /**
     * @param Event $subject
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        if ($this->authorizationChecker->isGranted('ROLE_WEBSITE')) {
            return true;
        }

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
