<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;


class SearchController extends AbstractController
{
    #[Route('/searchSerie', name: 'searchMedia')]
    public function searchMedia(Request $request): Response
    {
        $searchTerm = $request->query->get('query');
        // $mediaType = "tv";


        $client = HttpClient::create();
        $apiUrl = 'https://api.themoviedb.org/3/search/tv?query='.$searchTerm;
        $response = $client->request('GET', $apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJiOTZjOTdmMzUyYzMxYTdhM2QyNjM4OWNlM2Q1ZDBiYyIsInN1YiI6IjY1MGE5ZmNkOTY2MWZjMDFlNmRhMmE3ZSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.6Mw5oUTKiAEuR98piyoxob9_kjoyd_fSGqMTaFGTRGo',
                'accept' => 'application/json',
            ],
        ]);
        

        $searchResults = json_decode($response->getContent(), true);

        $filteredResults = array_filter($searchResults['results'], function ($result) use ($searchTerm) {
            $title = $result['title'] ?? '';
            $originalTitle = $result['original_title'] ?? '';
            $overview = $result['overview'] ?? '';
            return stripos($title, $searchTerm) !== false || stripos($originalTitle, $searchTerm) !== false || stripos($overview, $searchTerm) !== false;
        });
        // dd($filteredResults);


        return $this->render('search/searchSerie.html.twig', [
            'searchResults' => ['results' => $filteredResults],
            'searchTerm' => $searchTerm,
            // 'mediaType' => $mediaType,
        ]);
    }
}
