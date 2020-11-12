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
            echo 'Problème sur la base de données.';
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
                $requestManager = new RequestManager();
                $result = $requestManager->insert($myRequest);

                if ($result === true) {
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
        $measurements = $measurementManager->selectAll();
        $users = $this->selectAllUsers();

        return $this->twig->render(
            'Request/requestForm.html.twig',
            ['measurements' => $measurements, 'users' => $users, 'errors' => $errors]
        );
    }

    private function issetPost(array $myPost): array
    {
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

    public function acceptedList()
    {
        $errors = [];

        $requestManager = new RequestManager();
        $requests = $requestManager->selectAllAcceptedRequests();

        if ($requests === null) {
            $errors[] = 'Problème sur la base de données.';
        }

        $users = $this->selectAllUsers();

        return $this->twig->render(
            'Request/answeredRequests.html.twig',
            ['requests' => $requests,'users' => $users, 'errors' => $errors]
        );
    }

    public function acceptedListByUser()
    {
        $errors = [];
        $requests = [];
        $users = [];
        $answererId = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId'])) {
            if ($_POST['userId'] !== 'Toutes les demandes') {
                $answererId = trim($_POST['userId']);
                $answererId = (int)$answererId;

                $requestManager = new RequestManager();
                $requests = $requestManager->selectAllAcceptedById($answererId);

                if (!isset($requests['error'])) {
                    $users = $this->selectAllUsers();
                } else {
                    $errors = $requests['error'];
                }
            } else {
                header('Location:/request/acceptedList');
                return '';
            }
        }
        return $this->twig->render(
            'Request/answeredRequests.html.twig',
            ['requests' => $requests, 'users' => $users, 'errors' => $errors, 'selectedUser' => $answererId]
        );
    }

    private function selectAllUsers(): array
    {
        return (new UserManager())->selectAll();
    }
}
