<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\RequestManager;
use App\Model\UserManager;

class RequestController extends AbstractController
{

    /**
     * Display requests page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    
    public function list()
    {
        $requestManager = new RequestManager();
        $request = $requestManager->selectAllRequests();

        return $this->twig->render('Request/seeRequest.html.twig', ['requests' => $request]);
    }
}
