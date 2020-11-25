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
        $requests = $requestManager->selectAllRequests();
        $users = $this->selectAllUsers();

        if ($requests === null) {
            $errors['bdd'] = 'Problème sur la base de données.';
        }
        return $this->twig->render(
            'Request/seeRequest.html.twig',
            ['requests' => $requests, 'users' => $users, 'errors' => $errors]
        );
    }

    public function listExpress()
    {
        $answererId = $this->getAnswererId();
        $requestManager = new RequestManager();
        $requests = $requestManager->selectAllRequests();
        $users = $this->selectAllUsers();

        if ($requests === null) {
            echo 'Problème sur la base de données.';
        }
        return $this->twig->render(
            'Request/listExpress.html.twig',
            ['requests' => $requests, 'users' => $users, 'answererId' => $answererId]
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
        $measurements = $measurementManager->selectAll();
        $users = $this->selectAllUsers();

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

    public function acceptedList()
    {
        $errors = [];

        $requestManager = new RequestManager();
        $requests = $requestManager->selectAllAcceptedRequests();

        if ($requests === null) {
            $errors[] = 'Problème sur la base de données.';
        }

        $users = $this->selectAllUsers();

        $requests = self::getAnswererInfo($requests);

        return $this->twig->render(
            'Request/answeredRequests.html.twig',
            ['requests' => $requests, 'users' => $users, 'errors' => $errors]
        );
    }

    public function acceptedListByUser()
    {
        $errors = [];
        $requests = [];
        $users = [];
        $answererId = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId'])) {
            if ($_POST['userId'] !== '-- --') {
                $answererId = trim($_POST['userId']);

                if (filter_var($answererId, FILTER_VALIDATE_INT) !== false) {
                    $answererId = intval($answererId);

                    $requestManager = new RequestManager();
                    $requests = $requestManager->selectAllAcceptedById($answererId);

                    $requests = self::getAnswererInfo($requests);

                    if (!isset($requests['error'])) {
                        $users = $this->selectAllUsers();
                    } else {
                        $errors = $requests['error'];
                    }
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

    /*this method is called when a user decide to take care of the user request of someone else */
    public function takeCare(string $source)
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
                            return $this->chooseHeaderTrue($source);
                        } else {
                            $errors['BDD'] = 'Problème sur la base de données.';
                        }
                    }
                }
            } else {
                return $this->chooseHeaderFalse($source);
            }
        }
    }

    private function chooseHeaderTrue(string $source): string
    {
        if ($source === 'classic') {
            header('Location:/request/list');
            return '';
        } elseif ($source === 'express') {
            return $this->listExpress();
        } else {
            header('Location:/');
            return '';
        }
    }

    private function chooseHeaderFalse(string $source): string
    {
        if ($source === 'classic') {
            header('Location:/request/list#popup' . $_POST['requestId']);
            return '';
        } elseif ($source === 'express') {
            header('Location:/request/listExpress');
            return '';
        } else {
            header('Location:/');
            return '';
        }
    }

    public function getAnswererId(): string
    {
        if (isset($_POST['userId'])) {
            $answererId = $_POST['userId'];
            return $answererId;
        } else {
            return '';
        }
    }

    public function deleteRequest(int $id): string
    {
        $error = [];

        $requestManager = new RequestManager();
        $result = $requestManager->delete($id);

        if (!$result) {
            $error['bdd'] = 'Problème sur la base de données.';
        }

        header('Location:/request/acceptedList');
        return '';
    }

    private function getAnswererInfo(array $requests): array
    {
        $answerers = [];

        $nbRequests = count($requests);
        for ($i = 0; $i < $nbRequests; $i++) {
            $answerers[$i] = (
                new UserManager())->selectAnswererInfo($requests[$i]['fk_answerer_id']);

            $requests[$i]['answererFirstname'] = $answerers[$i]['firstname'];
            $requests[$i]['answererLastname'] = $answerers[$i]['lastname'];
        }

        return $requests;
    }
}
