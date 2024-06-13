<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Event;
use App\Event\Search\DatabaseEventSearch;
use App\Event\Search\EventSearchInterface;
use App\Form\EventType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class EventController extends AbstractController
{
    public function __construct(
        private readonly DatabaseEventSearch $databaseEventSearch,
        private readonly EventSearchInterface $eventSearch,
    ) {
    }

    #[Route(
        path: '/events/new',
        name: 'app_event_new',
        methods: ['GET', 'POST']
    )]
    public function newEvent(Request $request, EntityManagerInterface $em): Response
    {
        $event = new Event();

        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('app_event_show', ['id' => $event->getId()]);
        }

        return $this->render('event/new_event.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/events', name: 'app_event_list', methods: ['GET'])]
    public function list(Request $request): Response
    {
        $name = $request->query->get('name');

        return $this->render('event/list_events.html.twig', [
            'events' => $this->databaseEventSearch->searchByName($name),
        ]);
    }

    #[Route('/events/search', name: 'app_event_search', methods: ['GET'])]
    #[Template('event/search_events.html.twig')]
    public function searchEvents(Request $request): array
    {
        $events = $this->eventSearch->searchByName($request->query->get('name', null))['hydra:member'];

        return ['events' => $events];
    }

    #[Route(
        '/events/{id}',
        name: 'app_event_show',
        requirements: [
            'id' => Requirement::DIGITS,
        ],
        methods: ['GET']
    )]
    public function show(Event $event): Response
    {
        return $this->render('event/show_event.html.twig', [
            'event' => $event,
        ]);
    }
}
