<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Event;
use App\Routing\EventRequirement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route(
        path: '/event/{name}/{start}/{end}',
        name: 'app_event_new',
        requirements: [
            'name' => EventRequirement::NAME,
            'start' => EventRequirement::DATE,
            'end' => EventRequirement::DATE,
        ],
    )]
    public function newEvent(string $name, string $start, string $end, EntityManagerInterface $em): Response
    {
        $event = (new Event())
            ->setName($name)
            ->setDescription('Some generic description')
            ->setAccessible(true)
            ->setStartAt(new \DateTimeImmutable($start))
            ->setEndAt(new \DateTimeImmutable($end))
        ;

        $em->persist($event);
        $em->flush();

        return new Response('Event created');
    }
}