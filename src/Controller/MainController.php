<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route(path: '/', name: 'homepage', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $name = $request->query->get('name');

        return new Response('Hello ' . $name);
    }
}
