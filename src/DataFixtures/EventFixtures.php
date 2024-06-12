<?php

namespace App\DataFixtures;

use App\Entity\Event;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 15; $i <= 25; $i++) {
            $year = "20{$i}";
            $event = (new Event())
                ->setName("SymfonyLive {$year}")
                ->setDescription('Share your best practices, experiences and knowledge with Symfony.')
                ->setAccessible(true)
                ->setStartAt(new DateTimeImmutable("28-03-{$year}"))
                ->setEndAt(new DateTimeImmutable("29-03-{$year}"))
            ;

            $this->addReference("Event_{$year}", $event);

            $manager->persist($event);
        }

        $manager->flush();
    }
}
