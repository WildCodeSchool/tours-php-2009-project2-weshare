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

    /*this method is called to load the requests list page */
    public function list()
    {
        $errors = [];

        $requestManager = new RequestManager();
        $userManager = new UserManager();
        $requests = $requestManager->selectAllRequests();
        $users = $userManager->selectAll();

        if ($requests === null) {
            $errors['bdd'] = 'Problème sur la base de données.';
        }
        return $this->twig->render(
            'Request/seeRequest.html.twig',
            ['requests' => $requests, 'users' => $users, 'errors' => $errors]
        );
    }

    /*this method is called when a user add a new user request*/
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

    /*this method is called in the add() for check our form */
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

    /*this method is called when a user decide to take care of the user request of someone else */
    public function takeCare()
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId']) && isset($_POST['requestId'])) {
            if ($_POST['userId'] != '-- --') {
                $answererId = trim($_POST['userId']);
                $requestId = trim($_POST['requestId']);

                if (filter_var($answererId, FILTER_VALIDATE_INT) !== false) {
                    if (filter_var($requestId, FILTER_VALIDATE_INT) !== false) {
                        $answererId = intval($answererId);
                        $requestId = intval($requestId);

                        $requestManager = new RequestManager();
                        $result = $requestManager->updateOnAnswerer($answererId, $requestId);

                        if ($result === true) {
                            header('Location:/request/list');
                            return '';
                        } else {
                            $errors['BDD'] = 'Problème sur la base de données.';
                        }
                    }
                }
            } else {
                header('Location:/request/list#popup' . $_POST['requestId']);
            }
        }
    }
}
