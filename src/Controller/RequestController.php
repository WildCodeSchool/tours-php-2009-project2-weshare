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
        $userManager = new UserManager();
        $requests = $requestManager->selectAllRequests();
        $users = $userManager->selectAll();

        if ($requests === null) {
            echo 'Problème sur la base de données.';
        }
        return $this->twig->render('Request/seeRequest.html.twig', ['requests' => $requests, 'users' => $users]);
    }

    public function add()
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title']) && isset($_POST['userId'])) {
            $myPost = $this->issetPost();

            $myRequest = new Request(
                $myPost['userId'],
                $myPost['title'],
                $myPost['quantity'],
                $myPost['measurementId'],
                $myPost['description']
            );

            if ($myRequest->isValid()) {
                $requestManager = new RequestManager();
                $result = $requestManager->insert($myRequest);

                if ($result) {
                    header('Location:/request/list');
                    return '';
                } else {
                    $errors['BDD'] = 'Problème sur la base de données.';
                }
            } else {
                $errors = $myRequest->getErrors();
            }
        }

        $measurementManager = new MeasurementManager();
        $userManager = new UserManager();
        $measurements = $measurementManager->selectAll();
        $users = $userManager->selectAll();

        return $this->twig->render(
            'Request/requestForm.html.twig',
            ['measurements' => $measurements, 'users' => $users, 'errors' => $errors]
        );
    }

    private function issetPost(): array
    {
        $myPost = $_POST;
        if (isset($myPost['quantity']) && $myPost['quantity'] == '') {
            $myPost['quantity'] = null;
        }
        if (isset($myPost['measurementId']) && $myPost['measurementId'] == '-- --') {
            $myPost['measurementId'] = null;
        }
        if (isset($myPost['description']) && $myPost['description'] == '') {
            $myPost['description'] = null;
        }
        return $myPost;
    }

    public function takeCare()
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId']) && isset($_POST['requestId'])) {
            if ($_POST['userId'] != '-- --') {
                $answererId = trim($_POST['userId']);
                $requestId = trim($_POST['requestId']);
                $answererId = filter_var($answererId, FILTER_VALIDATE_INT);
                $requestId = filter_var($requestId, FILTER_VALIDATE_INT);
                $requestManager = new RequestManager();
                $result = $requestManager->updateOnAnswerer($answererId, $requestId);

                if ($result === true) {
                    header('Location:/request/list');
                    return '';
                } else {
                    $errors['BDD'] = 'Problème sur la base de données.';
                }
            } else {
                header('Location:/request/list#popup' . $_POST['requestId']);
            }
        }
    }
}
