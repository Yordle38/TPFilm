<?php

namespace  App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;//pour client

use App\Entity\Movie; //pour les films
use App\Entity\Actor; //pour les acteurs



#[Route('/movie')]
class MovieController extends AbstractController{
    #[Route('/all')]
    public function getMovies(): Response
    {
        $movies=[];//tableau des films

        $client = HttpClient::create();
        $apiUrl = 'https://api.themoviedb.org/3/movie/popular';//films populaires
        $response = $client->request('GET', $apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJiOTZjOTdmMzUyYzMxYTdhM2QyNjM4OWNlM2Q1ZDBiYyIsInN1YiI6IjY1MGE5ZmNkOTY2MWZjMDFlNmRhMmE3ZSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.6Mw5oUTKiAEuR98piyoxob9_kjoyd_fSGqMTaFGTRGo',
                'accept' => 'application/json',
            ],
        ]);

        $data = json_decode($response->getContent(), true);//contenue du json

        if (isset($data['results']) && is_array($data['results'])) {
            foreach ($data['results'] as $movieData) {
                // Initialise les propriétés de Movie selon les données JSON

                $releaseDate=new \DateTime($movieData['release_date']);
                $picturePath='https://image.tmdb.org/t/p/original'.$movieData["poster_path"];

                $movie = new Movie($movieData["id"], $movieData["title"], $picturePath, $movieData["video"],$movieData["overview"], $movieData["original_language"], $movieData["adult"], $releaseDate, $movieData["vote_average"]);
                //rajoute le film à la liste des films
                $movies[] = $movie;
            }
        }
        return $this->render('movies.html.twig', [
            'movies' => $movies
        ]);

        // return new Response($response->getContent());
    }

    #[Route('/{id}')]
    public function getCredits(int $id) :Response{
        $actors=[];//tableau des films

        $client = HttpClient::create();
        $apiUrl = 'https://api.themoviedb.org/3/movie/'.$id.'/credits';//crédits du film
        $response = $client->request('GET', $apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJiOTZjOTdmMzUyYzMxYTdhM2QyNjM4OWNlM2Q1ZDBiYyIsInN1YiI6IjY1MGE5ZmNkOTY2MWZjMDFlNmRhMmE3ZSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.6Mw5oUTKiAEuR98piyoxob9_kjoyd_fSGqMTaFGTRGo',
                'accept' => 'application/json',
            ],
        ]);
        $data = json_decode($response->getContent(), true);//contenue du json

        if (isset($data['cast']) && is_array($data['cast'])) {
            foreach ($data['cast'] as $actorData) {
                // Initialise les propriétés de Actor selon les données JSON
                $actor = new Actor($actorData["id"], $actorData["gender"],$actorData["name"],$actorData["character"]);
                //rajoute le film à la liste des films
                // $movie->addActor($actor); //A AJOUTER PLUS TARD
                $actors[] = $actor;
            }
        }

        return $this->render('credits.html.twig', [
            'actors' => $actors
        ]);

        // return new Response($response->getContent());


    }
        
}
