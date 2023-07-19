<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/series', name: 'series_')]

class SerieController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function list(SerieRepository $serieRepository): Response
    {
        /*$series = $serieRepository->findAll();*/

        $series = $serieRepository->findBestSeries();

        return $this->render('series/list.html.twig', [
            'series' => $series,
        ]);
    }

    #[Route('/details/{id}', name: 'details')]
    public function details(int $id, SerieRepository $serieRepository): Response
    {
        $serie = $serieRepository->find($id);

        return $this->render('series/details.html.twig', [
            'serie' => $serie
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(): Response
    {
        $serie = new Serie();
        $serieForm = $this->createForm(SerieType::class, $serie);

        //traiter le formulaire

        return $this->render('series/create.html.twig', [
            'serieForm' => $serieForm->createView()
        ]);
    }

    #[Route('/demo', name: 'em-demo')]
    public function demo(EntityManagerInterface $entityManager): Response
    {
        /*$serie = new Serie();
        $serie->setName('The Mandalorian');
        $serie->setBackdrop('https://image.tmdb.org/t/p/w1280/BbNvKCuEF4SRzFXR16aK6ISFtR.jpg');
        $serie->setPoster('https://image.tmdb.org/t/p/w1280/sWgBv7LV2PRoQgkxwlibdGXKz1S.jpg');
        $serie->setDateCreated(new \DateTime());
        $serie->setFirstAirDate(new \DateTime('2019-11-12'));
        $serie->setLastAirDate(new \DateTime('2020-12-18'));
        $serie->setGenres('Drama');
        $serie->setOverview('After the fall of the Galactic Empire, lawlessness has spread throughout the galaxy. A lone gunfighter makes his way through the outer reaches, earning his keep as a bounty hunter.');
        $serie->setPopularity('208.461');
        $serie->setVote('8.5');
        $serie->setStatus('Returning Series');
        $serie->setTmdbId('82856');

        dump($serie);

        $entityManager->persist($serie);
        $entityManager->flush();

        dump($serie);

        $serie->setGenres('Comedy');

        $entityManager->flush();*/


        return $this->render('series/create.html.twig');
    }
}
