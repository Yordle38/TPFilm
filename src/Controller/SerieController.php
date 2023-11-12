<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Doctrine\ORM\EntityManagerInterface;



use App\Entity\Serie;
use App\Entity\Actor;
use App\Entity\Avis;
use App\Form\AvisType;

#[Route('/serie')]
class SerieController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/all', name: 'series_list')]
    public function getSeries(): Response
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
                $releaseDate = new \DateTime($serieData["first_air_date"]);
                $picturePath='https://image.tmdb.org/t/p/original'.$serieData["poster_path"];
                
                //pays d'origine pas toujours définit donc vérif
                $originCountry = "unknown";
                if (isset($serieData["origin_country"]) && is_array($serieData["origin_country"]) && isset($serieData["origin_country"][0])) {
                    $originCountry = $serieData["origin_country"][0];
                }
                //creer la serie à l'aide des informations récupérées
                $serie = new Serie(
                     $serieData["id"],
                     $serieData["original_name"],
                     $serieData["overview"],
                     $serieData["id"], //nombre de saisons pas trouvé
                     $serieData["original_language"],
                     $serieData["id"], //nombre d'épisodes non plus
                     $serieData["vote_count"],
                     $serieData["vote_average"],
                     $originCountry,
                     $picturePath,
                     $releaseDate,
                     $serieData["adult"],
                 );


                //rajoute la serie à la liste des series
                $series[] = $serie;
            }
            // dd($series);

        }
        return $this->render('serie/allSeries.html.twig', [
            'series' => $series
        ]);

    }
    
    #[Route('/{id}', name: 'serie_details')]
    public function getDetails(int $id , EntityManagerInterface $entityManager): Response
    {
        $client = HttpClient::create();
        $apiUrl = 'https://api.themoviedb.org/3/tv/'.$id;//crédits du film
        $response = $client->request('GET', $apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJiOTZjOTdmMzUyYzMxYTdhM2QyNjM4OWNlM2Q1ZDBiYyIsInN1YiI6IjY1MGE5ZmNkOTY2MWZjMDFlNmRhMmE3ZSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.6Mw5oUTKiAEuR98piyoxob9_kjoyd_fSGqMTaFGTRGo',
                'accept' => 'application/json',
            ],
        ]);
        $serieData = json_decode($response->getContent(), true);//contenue du json
        
        $serie=null;
        
        if (is_array($serieData)) {
            $releaseDate = new \DateTime($serieData["first_air_date"]);
            $picturePath='https://image.tmdb.org/t/p/original'.$serieData["poster_path"];
            
            //pays d'origine pas toujours définit donc vérif
            $originCountry = "unknown";
            if (isset($serieData["origin_country"]) && is_array($serieData["origin_country"]) && isset($serieData["origin_country"][0])) {
                $originCountry = $serieData["origin_country"][0];
            }

            //creer la serie à l'aide des informations récupérées
            $foundSerie = new Serie(
                 $serieData["id"],
                 $serieData["original_name"],
                 $serieData["overview"],
                 $serieData["id"], //nombre de saisons pas trouvé
                 $serieData["original_language"],
                 $serieData["id"], //nombre d'épisodes non plus
                 $serieData["vote_count"],
                 $serieData["vote_average"],
                 $originCountry,
                 $picturePath,
                 $releaseDate,
                 $serieData["adult"],
             );
             $serie=$foundSerie;
        }
        $form = $this->createForm(AvisType::class);

        $actors=$this->getActors($id); //parfois aucun acteur renseigné en bdd
        $comments=$this->getComments($id);
        $form->get('note')->setData(3); // Pré-rempli le champ 'idSerie' avec l'ID de la série

        return $this->render('serie/serieDetail.html.twig', [
            'serie' => $serie,
            'actors' => $actors,
            'comments' => $comments,
            'form' => $form->createView(),
        ]);
    }

    public function getActors(int $id){
        $actors=[];//tableau des acteurs

        $client = HttpClient::create();
        $apiUrl = 'https://api.themoviedb.org/3/tv/'.$id.'/credits';//crédits de la série
        $response = $client->request('GET', $apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJiOTZjOTdmMzUyYzMxYTdhM2QyNjM4OWNlM2Q1ZDBiYyIsInN1YiI6IjY1MGE5ZmNkOTY2MWZjMDFlNmRhMmE3ZSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.6Mw5oUTKiAEuR98piyoxob9_kjoyd_fSGqMTaFGTRGo',
                'accept' => 'application/json',
            ],
        ]);
        
        $data = json_decode($response->getContent(), true);//contenue du json

        if (isset($data['cast']) && is_array($data['cast'])) {

            foreach ($data['cast'] as $actorData) {
                $picturePath='https://image.tmdb.org/t/p/original'.$actorData["profile_path"];

                // Initialise l'acteur
                $actor = new Actor($actorData["id"], $actorData["gender"],$actorData["name"],$actorData["character"], $picturePath);
                
                //rajoute l'acteur à la liste des acteurs
                $actors[] = $actor;
            }
        }
        return $actors;
    }

    
    public function getComments(int $id){
        //tableau qui contiendra l'ensemble des commentaires
        $comments=[];

        $client = HttpClient::create();
        $apiUrl = 'https://api.themoviedb.org/3/tv/'.$id.'/reviews';
        $response = $client->request('GET', $apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJiOTZjOTdmMzUyYzMxYTdhM2QyNjM4OWNlM2Q1ZDBiYyIsInN1YiI6IjY1MGE5ZmNkOTY2MWZjMDFlNmRhMmE3ZSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.6Mw5oUTKiAEuR98piyoxob9_kjoyd_fSGqMTaFGTRGo',
                'accept' => 'application/json',
            ],
        ]);

        $data = json_decode($response->getContent(), true);//contenue du json
        // if (isset($data['results']) && is_array($data['results'])) {
        //     foreach ($data['results'] as $commentResult) {

        //         $result_rate=$commentResult['author_details'];
        //         $id_comm=$commentResult['id'];

        //         $note=$result_rate['rating'];
        //         $username=$result_rate['username'];
        //         if($note==null){
        //             $note=0.0;
        //         }
        //         $content=$commentResult['content'];

        //         //Creation du commentaire
        //         $comment=new Avis($id_comm,$note,$content,"", $username);

        //         $comments[]= $comment;
        //     }
        // }
        $comments = $this->entityManager->getRepository(Avis::class)->findBy(['idmovie' => $id]); //idmovie = idserie
        return $comments;
    }

    public function getSerieById(int $id){
        $client = HttpClient::create();
        $apiUrl = 'https://api.themoviedb.org/3/tv/'.$id;//crédits du film
        $response = $client->request('GET', $apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJiOTZjOTdmMzUyYzMxYTdhM2QyNjM4OWNlM2Q1ZDBiYyIsInN1YiI6IjY1MGE5ZmNkOTY2MWZjMDFlNmRhMmE3ZSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.6Mw5oUTKiAEuR98piyoxob9_kjoyd_fSGqMTaFGTRGo',
                'accept' => 'application/json',
            ],
        ]);
        $serieData = json_decode($response->getContent(), true);//contenue du json
        
        $serie=null;
        
        if (is_array($serieData)) {
            $releaseDate = new \DateTime($serieData["first_air_date"]);
            $picturePath='https://image.tmdb.org/t/p/original'.$serieData["poster_path"];
            
            //pays d'origine pas toujours définit donc vérif
            $originCountry = "unknown";
            if (isset($serieData["origin_country"]) && is_array($serieData["origin_country"]) && isset($serieData["origin_country"][0])) {
                $originCountry = $serieData["origin_country"][0];
            }

            //creer la serie à l'aide des informations récupérées
            $foundSerie = new Serie(
                $serieData["id"],
                $serieData["original_name"],
                $serieData["overview"],
                $serieData["id"], //nombre de saisons pas trouvé
                $serieData["original_language"],
                $serieData["id"], //nombre d'épisodes non plus
                $serieData["vote_count"],
                $serieData["vote_average"],
                $originCountry,
                $picturePath,
                $releaseDate,
                $serieData["adult"],
            );
            $serie=$foundSerie;
        }
        return $serie;
    }
}
