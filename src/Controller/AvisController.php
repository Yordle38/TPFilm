<?php

namespace App\Controller;
use App\Entity\Avis;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AvisType;


class AvisController extends AbstractController
{


    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/avis', name: 'app_avis')]
    public function index(): Response
    {
        return $this->render('avis/index.html.twig', [
            'controller_name' => 'AvisController',
        ]);
    }

    #[Route('/addSerieComment/{id}', name: 'add_serie_comment')]
    public function addSerieComment(int $id, Request $request): Response
    {
        $avis = new Avis();
        $avis->setIdmovie($id);

        $form = $this->createForm(AvisType::class, $avis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($avis);
            $this->entityManager->flush();

            $this->addFlash('success', 'Avis ajouté avec succès !');

            return $this->redirectToRoute('serie_details', ['id' => $id]);
        }
        return $this->render('avis/addAvis.html.twig', [
            'form' => $form,
        ]);
    }
}
