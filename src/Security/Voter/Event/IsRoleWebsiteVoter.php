<?php

declare(strict_types=1);

namespace App\Security\Voter\Event;

use App\Entity\Event;
use App\Security\Permission;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use function str_starts_with;

final class IsRoleWebsiteVoter implements VoterInterface
{
    public function __construct(
        private readonly AuthorizationCheckerInterface $authorizationChecker,
    ) {
    }

    /**
     * @param Event $subject
     */
    public function vote(TokenInterface $token, mixed $subject, array $attributes): int
    {
        $attribute = $attributes[0];

        if (str_starts_with($attribute, 'ROLE_')) {
            return self::ACCESS_ABSTAIN;
        }

        if ($attribute !== Permission::EVENT_EDIT || !$subject instanceof Event) {
            return self::ACCESS_ABSTAIN;
        }

        return $this->authorizationChecker->isGranted('ROLE_WEBSITE') === true ? self::ACCESS_GRANTED : self::ACCESS_ABSTAIN;
    }
}
