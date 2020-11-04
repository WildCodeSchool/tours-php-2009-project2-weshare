<?php
/**
 * Created by Wcs
 * User: Celia
 * Date: 04/11/2020
 */

namespace App\Controller;

use App\Model\RequestManager;
use App\Model\MeasurementManager;
use App\Model\UserManager;
use App\Model\Request;

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
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title']) && isset($_POST['userId'])) {
            $myPost = $this->issetPost($_POST);

            $myRequest = new Request(
                $myPost['userId'],
                $myPost['title'],
                $myPost['quantity'],
                $myPost['measurementId'],
                $myPost['description']
            );

            if ($myRequest->isValid()) {
                /*$request = [
                    'userId' => $myRequest->getUserId(),
                    'title' => $myRequest->getTitle(),
                    'quantity' => $myRequest->getQuantity(),
                    'measurementId' => $myRequest->getMeasurementId(),
                    'description' => $myRequest->getDescription()
                ];*/

                $requestManager = new RequestManager();
                $requestManager->insert($myRequest);
                header('Location:/request/list');
            } else {
                $errors = $myRequest->getErrors();
            }
        } else {
            $errors['notFull'] = 'Veuillez choisir au minimum votre nom dans la liste et un titre';
        }

        $measurementManager = new MeasurementManager();
        $userManager = new UserManager();
        $measurements = $measurementManager->selectAll();
        $users = $userManager->selectAll();

        return $this->twig->render(
            'Request/requestForm.html.twig',
            ['tables' => [['measurements' => $measurements], ['users' => $users], ['errors' => $errors]]]
        );
    }

    private function issetPost(array $myPost) : array
    {
        if (isset($myPost['quantity']) && $myPost['quantity'] == '') {
            $myPost['quantity'] = null;
        }
        if (isset($myPost['measurementId']) && $myPost['measurementId'] == '-- --') {
            $myPost['measurementId'] = null;
        }
        if (!isset($myPost['description'])) {
            $myPost['description'] = null;
        }

        return $myPost;
    }
}
