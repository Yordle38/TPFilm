<?php

namespace App\Controller;
use App\Entity\Avis;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class AvisController extends AbstractController
{
    #[Route('/avis', name: 'app_avis')]
    public function index(): Response
    {
        return $this->render('avis/index.html.twig', [
            'controller_name' => 'AvisController',
        ]);
    }

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    

    // #[Route('/addavisfilm/{id}', name: 'ajouter_avis_film')]
    // public function ajouterAvisFilm(int $id, Request $request): Response
    // {
    //     $avis = new Avis();
    //     $avis->setIdMovie($id);

    //     $form = $this->createForm(AvisFormType::class, $avis);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $this->entityManager->persist($avis);
    //         $this->entityManager->flush();

    //         $this->addFlash('success', 'Avis ajouté avec succès !');

    //         return $this->redirectToRoute('movie_details', ['id' => $id]);
    //     }
    //     return $this->render('ajouter.html.twig', [
    //         'form' => $form,
    //     ]);
    // }
}
