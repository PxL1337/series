<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/series', name: 'series_')]

class SerieController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function list(): Response
    {
        //todo: récupérer la liste des séries depuis la BDD

        return $this->render('series/list.html.twig', [
        ]);
    }

    #[Route('/details/{id}', name: 'details')]
    public function details(int $id): Response
    {
        //todo: récupérer les détails d'une série depuis la BDD

        return $this->render('series/details.html.twig', [
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(): Response
    {
        //todo: récupérer les détails d'une série depuis la BDD

        return $this->render('series/create.html.twig', [
        ]);
    }

}
