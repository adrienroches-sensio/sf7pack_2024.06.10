<?php

declare(strict_types=1);

namespace App\Security\Voter\Event;

use App\Entity\Event;
use App\Security\Permission;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class IsRoleWebsiteVoter extends Voter
{
    public function __construct(
        private readonly AuthorizationCheckerInterface $authorizationChecker,
    ) {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return Permission::EVENT_EDIT === $attribute && $subject instanceof Event;
    }

    /**
     * @param Event $subject
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        return $this->authorizationChecker->isGranted('ROLE_WEBSITE');
    }
}
