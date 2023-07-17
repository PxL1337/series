<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route("/", name: "main_home")]
    public function home() {
        return $this->render('main/home.html.twig');
    }

    #[Route("/test", name: "main_test")]
    public function test() {
        $serie = [
            "title" => "Game of Thrones",
            "year" => 2011,
            "synopsis" => "Game of Thrones is an American fantasy drama television series created by David Benioff and D. B. Weiss for HBO. It is an adaptation of A Song of Ice and Fire, a series of fantasy novels by George R. R. Martin, the first of which is A Game of Thrones. The show was shot in the United Kingdom, Canada, Croatia, Iceland, Malta, Morocco, and Spain. It premiered on HBO in the United States on April 17, 2011, and concluded on May 19, 2019, with 73 episodes broadcast over eight seasons.",
            "seasons" => 8,
            "episodes" => 73,
            "poster" => "https://images-na.ssl-images-amazon.com/images/I/91jz5yobQTL._AC_SL1500_.jpg",
            "genres" => ["fantasy", "drama", "adventure", "action"],
            "note" => 9.3,
            "comments" => [
                [
                    "username" => "toto",
                    "content" => "J'adore cette série !"
                ],
                [
                    "username" => "tata",
                    "content" => "J'aime pas cette série !"
                ]
            ]
        ];


        return $this->render('main/test.html.twig', [
            "serie" => $serie
        ]);
    }

}