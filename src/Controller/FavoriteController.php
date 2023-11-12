<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;//pour l'ajout en bdd de favorite

use App\Entity\Favorite; 

#[Route('/favorite')]

class FavoriteController extends AbstractController
{
    //ajoute un film à la liste des favoris
    #[Route('/addFavoriteMovie/{id}',name: 'add_movie_favorite')]
    public function addMovieToFavorite(EntityManagerInterface $entityManager, int $id): Response
    {
        $favorite = new Favorite();
        $favorite->setIdMovie($id);

        $entityManager->persist($favorite);
        $entityManager->flush();
        
        return $this->displayFavorite($entityManager);
    }

    //ajoute une serie à la liste des favoris
    #[Route('/addFavoriteSerie/{id}', name: 'add_serie_favorite')]
    public function addSerieToFavorite(EntityManagerInterface $entityManager, int $id){

        $favorite = new Favorite();
        $favorite->setIdSerie($id);

        $entityManager->persist($favorite);


        $entityManager->flush();

        return $this->displayFavorite($entityManager);
    }

    //fonction qui renvoie l'ensemble des favoris
    #[Route('/all')]
    function displayFavorite(EntityManagerInterface $entityManager): Response{

        $favorites = $entityManager->getRepository(Favorite::class)->findAll();

        return $this->render('favorite/index.html.twig', [
            'favorites' => $favorites,
        ]);
    }
}
