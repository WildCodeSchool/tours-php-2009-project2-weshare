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
        $requests = $requestManager->selectAllRequests();
        if ($requests === null) {
            echo 'Problème sur la base de données';
        }
        return $this->twig->render('Request/seeRequest.html.twig', ['requests' => $requests]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title']) &&
        isset($_POST['userId'])) {
            $userId = $_POST['userId'];
            $title = trim($_POST['title']);
            $quantity = trim($_POST['quantity']);
            $measurementId = trim($_POST['measurementId']);
            $description = trim($_POST['description']);

            $errors = [];

            if (strlen($title) <= 0) {
                $errors['title'] = "Le titre doit contenir au moins 1 caractère.";
            }

            if (strlen($title) > 41) {
                $errors['title'] = "Le titre doit contenir au maximum 40 caractères.";
            }

            if ($quantity <= 0) {
                $errors['quantity'] = "La quantité ne peut pas être plus petite ou égale à 0.";
            }

            $request = [
                'userId' => $userId,
                'title' => $title,
                'quantity' => $quantity,
                'measurementId' => $measurementId,
                'description' => $description
            ];

            if (empty($errors)) {
                $requestManager = new RequestManager();
                $requestManager->insert($request);
                header('Location:/request/list');
            }
        }
        $measurementManager = new MeasurementManager();
        $userManager = new UserManager();
        $measurements = $measurementManager->selectAll();
        $users = $userManager->selectAll();

        return $this->twig->render(
            'Request/requestForm.html.twig',
            ['tables' => [['measurements' => $measurements] , ['users' => $users]]]
        );
    }
}
