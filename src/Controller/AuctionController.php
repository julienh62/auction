<?php

namespace App\Controller;


use App\Form\SearchType;
use App\Repository\AuctionRepository;
use App\Repository\RaiseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\Turbo\TurboBundle;

class AuctionController extends AbstractController
{


    #[Route('/', name: 'home', methods: ['GET', 'POST'])]
    public function index(AuctionRepository $auctionRepository, Request $request, RaiseRepository $raiseRepository): Response
    {
        $auctions = $auctionRepository->findAll();
        $raise = $raiseRepository->findAll();


        $form = $this->createForm(SearchType::class);
        $searchResults = [];

            if ($form->isSubmitted() && $form->isValid()) {
                $formData = $form->getData();
                $auctionName = $formData['auction'];

                // Récupérez l'enchère correspondante au nom sélectionné
                $searchResult = $auctionRepository->findOneBy(['title' => $auctionName]);
                dd($searchResult);
            }

            return $this->render('auction/index.html.twig', [
                'auctions' => $auctions,
                'raise' => $raise,
                'searchResult' => $searchResults, // Enchère trouvée par la recherche
                'form' => $form,
            ]);
    }

    #[Route('/test', name: 'test', methods: ['GET'])]
    public function test(): Response
    {

        return $this->render('test/index.html.twig', [

        ]);
    }

    #[Route('/test2', name: 'test2')]
    public function bonjour(Request $request, RaiseRepository $raiseRepository, SessionInterface $session): Response
    {

        if (turboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);

        }
        return new Response("ok");
    }


 /*   #[Route('/search', name: 'search')]
    public function search(Request $request): Response
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Les données du formulaire sont disponibles ici
            $formData = $form->getData();

            // Effectuez ici vos opérations de recherche en fonction des données du formulaire
            // Par exemple, récupérer les valeurs sélectionnées
            $food = $formData['food'];
            $portionSize = $formData['portionSize'];

            // Faites quelque chose avec les valeurs sélectionnées...
            // Par exemple, retournez une réponse ou effectuez d'autres actions

            // Remplacez cela par votre propre logique de recherche et de traitement des données
            return $this->render('search/result.html.twig', [
                'auction' => $food,
                'portionSize' => $portionSize,
                // Ajoutez d'autres données à passer à votre vue si nécessaire
            ]);
        }

        return $this->render('search/index.html.twig', [
            'form' => $form->createView(),
        ]);
    } */
}

