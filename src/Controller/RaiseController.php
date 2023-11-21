<?php

namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Stream;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Raise;
use App\Entity\Auction;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\UX\Turbo\TurboBundle;

class RaiseController extends AbstractController
{
    #[Route('/raise/{auctionId}', name: 'submit_raise', methods: ['GET', 'POST'])]
    public function submitRaise(Request $request, EntityManagerInterface $em, int $auctionId
    , ValidatorInterface $validator): Response
    {

        // Récupérer l'enchère (Auction) correspondante
        $auction = $em->getRepository(Auction::class)->find($auctionId);

        if (!$auction) {
            throw $this->createNotFoundException('Enchère non trouvée pour cet identifiant');
        }


        // Récupérer le montant de l'enchère depuis la requête
        $raisepricefirst = $request->request->get('raise_price');
        $raiseprice = $raisepricefirst * 100 ;

        // Créer une nouvelle enchère (Raise)
        $raise = new Raise();
        $raise->setAuction($auction); // Associer l'enchère à la raise
        $raise->setPrice($raiseprice); // Définir le montant de l'enchère
        $raise->setCreatedAt(new \DateTime());
        $errors = $validator->validate($raise);
        if (count($errors)) {
            if (turboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
                $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
                return $this->render('error/error.stream.html.twig', [
                    'errors' => $errors,
                    'id' => $auctionId,
                ]);
            }


                // au cas ou pas de javascript dans le navigateur
            $this->addFlash('danger', $raiseprice. ' must be greater than highest raise');
            return $this->redirectToRoute('home');
        }
      //  $auction->setPrice($raiseprice); // Définir le montant de l'enchère

        // Persistir la raise dans la base de données
        $em->persist($raise);
      //  $em->persist($auction);
        $em->flush();

        if (turboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('success/success.stream.html.twig', [
               'raiseprice' => $raiseprice,
                'id' => $auctionId,
            ]);
        }

        // mettre à jour l' enchère (Auction)
       // $raise->setCreatedAt(new \DateTime());

        // Redirection vers une page de confirmation ou toute autre action souhaitée
        return $this->render('raise/stream.html.twig', ["id"=>2]);
    }

}

