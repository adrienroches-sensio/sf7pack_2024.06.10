<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Organization;
use App\Entity\Project;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrganizationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $organization = (new Organization())
            ->setName('Symfony')
            ->setCreatedAt(new DateTimeImmutable('2018'))
            ->setPresentation('Symfony SAS is the company behind Symfony, the PHP Open-Source framework.')
        ;

        $organization->addProject($this->getReference(ProjectFixtures::SymfonyLive, Project::class));

        for ($i = 2015; $i <= 2025; $i++) {
            $organization->addEvent($this->getReference("Event_{$i}", Event::class));
        }

        $manager->persist($organization);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EventFixtures::class,
            ProjectFixtures::class,
        ];
    }
}
