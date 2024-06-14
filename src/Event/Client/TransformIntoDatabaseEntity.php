<?php

declare(strict_types=1);

namespace App\Event\Client;

use App\Entity\Event;
use App\Entity\Organization;
use App\Repository\EventRepository;
use App\Repository\OrganizationRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use function array_map;

final class TransformIntoDatabaseEntity
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly EventRepository $eventRepository,
        private readonly OrganizationRepository $organizationRepository,
        private readonly AuthorizationCheckerInterface $authorizationChecker,
    ) {
    }

    /**
     * @return list<Event>
     */
    public function transform(array $searchResults): array
    {
        /** @var array<string, Organization> $organizations */
        $organizations = [];

        $isOrganizerOrWebsite = $this->authorizationChecker->isGranted('ROLE_WEBSITE') || $this->authorizationChecker->isGranted('ROLE_ORGANIZER');

        return array_map(function (mixed $eventResult) use ($organizations, $isOrganizerOrWebsite): Event {
            $event = $this->eventRepository->searchOneByName($eventResult['name']);

            if (null !== $event) {
                return $event;
            }

            $event = (new Event())
                ->setName($eventResult['name'])
                ->setAccessible($eventResult['accessible'])
                ->setDescription($eventResult['description'])
                ->setStartAt(new DateTimeImmutable($eventResult['startDate']))
                ->setEndAt(new DateTimeImmutable($eventResult['endDate']))
            ;

            $organizationsResult = $eventResult['organizations'];

            foreach ($organizationsResult as $organizationResult) {
                $organization = $organizations[$organizationResult['name']] ?? $this->organizationRepository->searchOneByName($organizationResult['name']);

                if (null === $organization) {
                    $organization = (new Organization())
                        ->setName($organizationResult['name'])
                        ->setPresentation($organizationResult['presentation'])
                        ->setCreatedAt(new DateTimeImmutable($organizationResult['createdAt']))
                    ;

                    if (true === $isOrganizerOrWebsite) {
                        $this->entityManager->persist($organization);
                    }

                    $organizations[$organizationResult['name']] = $organization;
                }
            }

            if (true === $isOrganizerOrWebsite) {
                $this->entityManager->persist($event);
                $this->entityManager->flush();
            }

            return $event;
        }, $searchResults['hydra:member']);
    }
}
