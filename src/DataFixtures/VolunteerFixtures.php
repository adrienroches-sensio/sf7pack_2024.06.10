<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Project;
use App\Entity\User;
use App\Entity\Volunteer;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VolunteerFixtures extends Fixture implements DependentFixtureInterface
{
    private const VOLUNTEERS = [
        [
            'user' => 'user',
            'event' => '20',
            'start' => '2024-05-12',
            'end' => '2024-05-13',
        ],
        [
            'user' => 'admin',
            'event' => '20',
            'start' => '2024-05-12',
            'end' => '2024-05-13',
        ],
        [
            'user' => 'website',
            'event' => '20',
            'start' => '2024-05-12',
            'end' => '2024-05-13',
        ],
        [
            'user' => 'organizer',
            'event' => '20',
            'start' => '2024-05-12',
            'end' => '2024-05-13',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::VOLUNTEERS as $volunteerData) {
            $volunteer = (new Volunteer())
                ->setForUser($this->getReference($volunteerData['user'], User::class))
                ->setProject($this->getReference(ProjectFixtures::SymfonyLive, Project::class))
                ->setEvent($this->getReference("Event_20{$volunteerData['event']}", Event::class))
                ->setStartAt(new DateTimeImmutable($volunteerData['start']))
                ->setEndAt(new DateTimeImmutable($volunteerData['end']))
            ;

            $manager->persist($volunteer);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            ProjectFixtures::class,
            EventFixtures::class,
        ];
    }
}
