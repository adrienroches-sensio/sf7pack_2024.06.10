<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Routing\EventRequirement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class EventController extends AbstractController
{
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
    public function list(EventRepository $eventRepository): Response
    {
        return $this->render('event/list_events.html.twig', [
            'events' => $eventRepository->list(),
        ]);
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
