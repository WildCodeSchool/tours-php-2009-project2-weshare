<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\RequestManager;

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
        $error = [];

        $requestManager = new RequestManager();
        $requests = $requestManager->selectFirsts();

        if ($requests === null) {
            $error = 'Problème sur la base de données.';
        }

        return $this->twig->render(
            'Home/index.html.twig',
            ['requests' => $requests, 'errorBDD' => $error]
        );
    }
}
