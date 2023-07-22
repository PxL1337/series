<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/series', name: 'series_')]

class SerieController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function list(SerieRepository $serieRepository, Request $request): Response
    {
        $series = $serieRepository->findBestSeries();

        return $this->render('series/list.html.twig', [
            'series' => $series,
        ]);
    }

    #[Route('/more', name: 'more')]
    public function more(Request $request, SerieRepository $serieRepository): Response
    {
        $offset = $request->query->get('offset', 0);
        $series = $serieRepository->findBy([], ['popularity' => 'DESC'], 50, $offset);

        $seriesArray = [];
        foreach ($series as $serie) {
            $seriesArray[] = [
                'id' => $serie->getId(),
                'name' => $serie->getName(),
                'poster' => $serie->getPoster(),
                'seasons' => count($serie->getSeasons()),
            ];
        }

        return $this->json($seriesArray);
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
    public function create(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        $serie = new Serie();
        $serie->setDateCreated(new \DateTime());

        $serieForm = $this->createForm(SerieType::class, $serie);

        $serieForm->handleRequest($request);

        if ($serieForm->isSubmitted() && $serieForm->isValid()) {
            // Handle the upload for the poster file
            if ($posterFile = $serieForm->get('posterFile')->getData()) {
                $originalFilename = pathinfo($posterFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$posterFile->guessExtension();
                try {
                    $posterFile->move(
                        $this->getParameter('posters_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Unable to upload the poster file, add a flash message
                    $this->addFlash('error', 'Unable to upload poster file: '.$e->getMessage());

                    return $this->render('series/create.html.twig', [
                        'serieForm' => $serieForm->createView()
                    ]);
                }
                $serie->setPoster($newFilename);
            }

            // Handle the upload for the backdrop file
            if ($backdropFile = $serieForm->get('backdropFile')->getData()) {
                $originalFilename = pathinfo($backdropFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$backdropFile->guessExtension();
                try {
                    $backdropFile->move(
                        $this->getParameter('backdrops_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Unable to upload the backdrop file, add a flash message
                    $this->addFlash('error', 'Unable to upload backdrop file: '.$e->getMessage());

                    return $this->render('series/create.html.twig', [
                        'serieForm' => $serieForm->createView()
                    ]);
                }
                $serie->setBackdrop($newFilename);
            }
            $entityManager->persist($serie);
            $entityManager->flush();

            $this->addFlash('success', 'Serie added! Good Job !');

            return $this->redirectToRoute('series_details', ['id'=>$serie->getId()]);
        }


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
