<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;

use App\Entity\Serie;
#[Route('/serie', name: 'app_serie')]
class SerieController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('serie/index.html.twig', [
            'controller_name' => 'SerieController',
        ]);
    }

    #[Route('/all')]
    public function getMovies(): Response
    {
        $series=[];//tableau des series

        $client = HttpClient::create();
        $apiUrl = 'https://api.themoviedb.org/3/tv/popular';//films populaires
        $response = $client->request('GET', $apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJiOTZjOTdmMzUyYzMxYTdhM2QyNjM4OWNlM2Q1ZDBiYyIsInN1YiI6IjY1MGE5ZmNkOTY2MWZjMDFlNmRhMmE3ZSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.6Mw5oUTKiAEuR98piyoxob9_kjoyd_fSGqMTaFGTRGo',
                'accept' => 'application/json',
            ],
        ]);

        $data = json_decode($response->getContent(), true);//contenue du json

        if (isset($data['results']) && is_array($data['results'])) {
            foreach ($data['results'] as $serieData) {
                // Initialise les propriétés de Movie selon les données JSON
                dd ($data);
                $releaseDate = new \DateTime($serieData["first_air_date"]);
                $picturePath='https://image.tmdb.org/t/p/original'.$serieData["poster_path"];

                //creer la serie à l'aide des informations récupérées
                $serie = new Serie(
                     $serieData["id"],
                     $serieData["original_name"],
                     $serieData["id"],
                     $serieData["original_language"],
                     $serieData["id"],
                     $serieData["vote_count"],
                     $serieData["vote_average"],
                     $serieData["origin_country"][0],
                     $picturePath,
                     $releaseDate,
                     $serieData["adult"],
                 );
                $serie=[];

                //rajoute la serie à la liste des series
                $series[] = $serie;
            }
        }
        return $this->render('serie/index.html.twig', [
            'series' => $series
        ]);

        // return new Response($response->getContent());
    }
}
