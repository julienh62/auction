<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TranslationController extends AbstractController
{
    #[Route('/locale/{locale}', name: 'locale')]
    public function index(Request $request, $locale): Response
    {
        if($locale == "fr")
        {
            $request->getSession()->set('locale', "fr");
        }
        else $request->getSession()->set('locale', "en");
        //dd($locale);

        $previousUrl = $request->headers->get("referer");
       // dd($previousUrl);
        if ($previousUrl !== null) {
            return $this->redirect($previousUrl);
        } else {
            // Redirige vers une route par défaut si l'URL précédente est nulle
            return $this->redirectToRoute('home');
        }

    }
}


