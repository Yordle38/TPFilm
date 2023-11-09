<?php

namespace  App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;//pour client
use Doctrine\ORM\EntityManagerInterface;//pour l'ajout en bdd de favorite


use App\Entity\Movie; //pour les films
use App\Entity\Actor; //pour les acteurs
use App\Entity\Avis; //pour les avis
use App\Entity\Favorite; //pour les favoris
use App\Form\AvisType;

#[Route('/movie')]
class MovieController extends AbstractController{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    //fonction qui recupere l'ensemble des films
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

    //fonction qui trouve le détail d'un film dont l'id est donné en param
    #[Route('/{id}',methods:['GET','POST'])]
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

        $avis = new Avis();
        $form = $this->createForm(AvisType::class, $avis);
        if ($form->isSubmitted() && $form->isValid()) {
            dd($avis);
        }
        if (isset($movieData) && is_array($movieData)) {
            $releaseDate=new \DateTime($movieData['release_date']);

            $picturePath='https://image.tmdb.org/t/p/original'.$movieData["poster_path"];

            $movie = new Movie($movieData["id"], $movieData["title"], $picturePath, $movieData["video"],$movieData["overview"], $movieData["original_language"], $movieData["adult"], $releaseDate, $movieData["vote_average"]);
        
            //Récupére les acteurs du film
            $actors=$this->getActors($movieData["id"]);

            foreach ($actors as $actor){
                //ajoute les acteurs au film
                $movie->addActor($actor);
            }

            //Recupere les commentaires du film en bdd
            $comments=$this->getComments($movieData["id"]);

            // $entityManager = $this->getDoctrine()->getManager();
            // $comments = $entityManager->getRepository(Avis::class)->findBy(['movie' => $movieData['id']]);
    


            // Vérifie si le formulaire est valide
          

            //retourne le film et ses détails
            return $this->render('movieDetail.html.twig', [
                'movie' => $movie,
                'comments'=> $comments,
                'form' => $form->createView()
            ]);
        }


       return new Response($response->getContent());
    }
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

    //prend en param l'id d'un film et retourne ses commentaires (classe Avis)
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

                $note=$result_rate['rating'];
                $username=$result_rate['username'];
                if($note==null){
                    $note=0.0;
                }
                $content=$commentResult['content'];

                // dd($commentResult);


                // $comment=new Avis($id_comm,$note,$content,"", $username);

                // $comments[]= $comment;
            }
        }
        $comments = $this->entityManager->getRepository(Avis::class)->findBy(['idmovie' => $id]);
        return $comments;
    }

    #[Route('/addFavorite/{id}')]
    public function createFavoris(EntityManagerInterface $entityManager, int $id): Response
    {
        $favorite = new Favorite();
        $favorite->setIdMovie($id);

        //premiere etape qui prepare la requete
        $entityManager->persist($favorite);

        //deuxieme etape qui execute la requete
        $entityManager->flush();
        
        return $this->displayFavorite($entityManager);
    }

    #[Route('/addAvis/{id}')]
    public function createAvis(EntityManagerInterface $entityManager, int $idMovie, int $note, string $commentaire): Response
    {
        $avis = new Avis();
        $avis->setIdmovie($idMovie);
        $avis->setNote($note);
        $avis->setComment($commentaire);


        //premiere etape qui prepare la requete
        $entityManager->persist($avis);

        //deuxieme etape qui execute la requete
        $entityManager->flush();
        
        return $this->getCredits($idMovie);
    }

    //fonction qui renvoie l'ensemble des favoris
    #[Route('/Favorite/all')]
    function displayFavorite(EntityManagerInterface $entityManager): Response{
        {
            $favorites = $entityManager->getRepository(Favorite::class)->findAll();
    
            // Vous pouvez maintenant passer la liste des favoris à votre template
            return $this->render('favorite/index.html.twig', [
                'favorites' => $favorites,
            ]);
        }
    }

}
