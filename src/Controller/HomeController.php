<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\DemandeManager;

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
        $demandeManager = new DemandeManager();
        $demande = $demandeManager->selectFirsts();

        return $this->twig->render('Home/index.html.twig', ['demandes' => $demande]);
    }
    
    public function seeDemands()
    {
        return $this->twig->render('Home/seeDemands.html.twig');
    }
}
