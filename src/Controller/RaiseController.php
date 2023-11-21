<?php

namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Raise;
use App\Entity\Auction;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Turbo\TurboBundle;

class RaiseController extends AbstractController
{
    #[Route('/raise/{auctionId}', name: 'submit_raise', methods: ['GET', 'POST'])]
    public function submitRaise(Request $request, EntityManagerInterface $em, int $auctionId): Response
    {

        // Récupérer l'enchère (Auction) correspondante
        $auction = $em->getRepository(Auction::class)->find($auctionId);

        if (!$auction) {
            throw $this->createNotFoundException('Enchère non trouvée pour cet identifiant');
        }

        if (turboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
        }
        // Récupérer le montant de l'enchère depuis la requête
        $raiseprice = $request->request->get('raise_price');


        // Créer une nouvelle enchère (Raise)
        $raise = new Raise();
        $raise->setAuction($auction); // Associer l'enchère à la raise
        $raise->setPrice($raiseprice); // Définir le montant de l'enchère
        $raise->setCreatedAt(new \DateTime());

        // Persistir la raise dans la base de données
        $em->persist($raise);
        $em->flush();

        // Redirection vers une page de confirmation ou toute autre action souhaitée
        return $this->render('raise/stream.html.twig', ["id"=>2]);
    }


}

