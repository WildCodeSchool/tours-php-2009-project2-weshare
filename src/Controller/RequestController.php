<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\RequestManager;
use App\Model\MeasurementManager;

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
        $requests = $requestManager->selectAllRequests();
        if ($requests === null) {
            echo 'Problème sur la base de données';
        }
        return $this->twig->render('Request/seeRequest.html.twig', ['requests' => $requests]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestManager = new RequestManager();
            $request = [
                'title' => $_POST['title'],
                'quantity' => $_POST['quantity'],
                'measurementId' => $_POST['measurementId'],
                'description' => $_POST['description']
            ];
            $requestManager->insert($request);
            header('Location:/home/index');
        }
        $measurementManager = new MeasurementManager();
        $measurements = $measurementManager->selectAll();

        return $this->twig->render('Request/requestForm.html.twig', ['measurements' => $measurements]);
    }
}
