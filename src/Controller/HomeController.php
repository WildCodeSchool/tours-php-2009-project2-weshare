<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\DemandeManager;
use App\Model\UtilisateurManager;

class HomeController extends AbstractController
{

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $utilisateurManager = new UtilisateurManager();
        $demandeManager = new DemandeManager();
        $demande = $demandeManager->selectFirsts($utilisateurManager->getTable());

        return $this->twig->render('Home/index.html.twig', ['demandes' => $demande]);
    }
    
    public function seeDemands()
    {
        return $this->twig->render('Home/seeDemands.html.twig');
    }
}
