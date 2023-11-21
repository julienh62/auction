<?php

namespace App\Controller;


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
        // phpinfo();
        //exit;
        $auctions = $auctionRepository->findAll();
        $raise = $raiseRepository->findAll();

        return $this->render('auction/index.html.twig', [
            'auctions' => $auctions,
            'raise' => $raise
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

                 return $this->render('stream.html.twig', ["id"=>2]);
              }
          return new Response("ok");
          }

    

}
