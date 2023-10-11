<?php

namespace  App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;//pour client

use App\Entity\Movie; //pour les films
use App\Entity\Actor; //pour les acteurs
use App\Entity\Avis; //pour les avis



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

                //creer le film à l'aide des informations récupérées
                $movie = new Movie($movieData["id"], $movieData["title"], $picturePath, $movieData["video"],$movieData["overview"], $movieData["original_language"], $movieData["adult"], $releaseDate, $movieData["vote_average"]);
                
                //Récupére les acteurs du film
                $actors=$this->getActors($movieData["id"]);

                foreach ($actors as $actor){
                    //ajoute les acteurs au film
                    $movie->addActor($actor);
                }
                
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

        $client = HttpClient::create();
        $apiUrl = 'https://api.themoviedb.org/3/movie/'.$id;//crédits du film
        $response = $client->request('GET', $apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJiOTZjOTdmMzUyYzMxYTdhM2QyNjM4OWNlM2Q1ZDBiYyIsInN1YiI6IjY1MGE5ZmNkOTY2MWZjMDFlNmRhMmE3ZSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.6Mw5oUTKiAEuR98piyoxob9_kjoyd_fSGqMTaFGTRGo',
                'accept' => 'application/json',
            ],
        ]);

        $movieData = json_decode($response->getContent(), true);//contenue du json
        // dd($movieData);
        if (isset($movieData) && is_array($movieData)) {

            $releaseDate=new \DateTime($movieData['release_date']);
            $picturePath='https://image.tmdb.org/t/p/original'.$movieData["belongs_to_collection"]["poster_path"];

            $movie = new Movie($movieData["id"], $movieData["title"], $picturePath, $movieData["video"],$movieData["overview"], $movieData["original_language"], $movieData["adult"], $releaseDate, $movieData["vote_average"]);
        
            //Récupére les acteurs du film
            $actors=$this->getActors($movieData["id"]);

            foreach ($actors as $actor){
                //ajoute les acteurs au film
                $movie->addActor($actor);
            }

            $comments=$this->getComments($movieData["id"]);

        
            //retourne le film et ses détails
            return $this->render('movieDetail.html.twig', [
                'movie' => $movie,
                'comments'=> $comments
            ]);
        }


       return new Response($response->getContent());
    }

    // #[Route('/{id}')]
    // public function getMovieDetails(int $id): Response
    // {
    //     $client = HttpClient::create();
    //     $apiUrl = 'https://api.themoviedb.org/3/movie/'.$id;//films populaires
    //     $response = $client->request('GET', $apiUrl, [
    //         'headers' => [
    //             'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJiOTZjOTdmMzUyYzMxYTdhM2QyNjM4OWNlM2Q1ZDBiYyIsInN1YiI6IjY1MGE5ZmNkOTY2MWZjMDFlNmRhMmE3ZSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.6Mw5oUTKiAEuR98piyoxob9_kjoyd_fSGqMTaFGTRGo',
    //             'accept' => 'application/json',
    //         ],
    //     ]);

    //     $data = json_decode($response->getContent(), true);//contenue du json
    //     // Récupérez le film correspondant à l'ID depuis votre source de données (par exemple, une base de données ou une API).
    //     // En supposant que vous avez une méthode pour récupérer un film par ID dans votre entité Movie.
    //     $movie = $this->getDoctrine()->getRepository(Movie::class)->find($id);
    
    //     if (!$movie) {
    //         // Gérez ici le cas où le film n'est pas trouvé, par exemple, redirigez vers une page d'erreur.
    //     }
    
    //     return $this->render('movie_details.html.twig', [
    //         'movie' => $movie,
    //     ]);
    // }




    public function getActors(int $id){
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
                
                //rajoute l'acteur à la liste des acteurs
                $actors[] = $actor;
            }
        }
        return $actors;
    }
    public function getComments(int $id): array
    {
        $client = HttpClient::create();
        $apiUrl = 'https://api.themoviedb.org/3/movie/'.$id.'/reviews';
        $response = $client->request('GET', $apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJiOTZjOTdmMzUyYzMxYTdhM2QyNjM4OWNlM2Q1ZDBiYyIsInN1YiI6IjY1MGE5ZmNkOTY2MWZjMDFlNmRhMmE3ZSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.6Mw5oUTKiAEuR98piyoxob9_kjoyd_fSGqMTaFGTRGo',
                'accept' => 'application/json',
            ],
        ]);

        $data = json_decode($response->getContent(), true);//contenue du json

        //tableau qui contiendra l'ensemble des commentaires
        $comments=[];
        if (isset($data['results']) && is_array($data['results'])) {
            foreach ($data['results'] as $commentResult) {

                $result_rate=$commentResult['author_details'];

                $id_comm=$commentResult['id'];
                // dd($data);

                $note=$result_rate['rating'];
                $username=$result_rate['username'];
                if($note==null){
                    $note=0.0;
                }
                $content=$commentResult['content'];

                $comment=new Avis($id_comm,$note,$content,"", $username);

                $comments[]= $comment;
            }
        }
        return $comments;
    }
}
