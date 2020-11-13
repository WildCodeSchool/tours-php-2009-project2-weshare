<?php

namespace App\Controller;

use App\Model\UserManager;
use App\Model\TownManager;
use App\Model\User;

/**
 * Class UserController
 *
 */
class UserController extends AbstractController
{

    public function add()
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $myPost = $this->issetPost();

            if ($myPost !== null) {
                $myUser = new User(
                    $myPost['firstname'],
                    $myPost['lastname'],
                    $myPost['phone'],
                    $myPost['street'],
                    $myPost['townId'],
                    $myPost['email']
                );

                if ($myUser->isValid()) {
                    $userManager = new UserManager();
                    $result = $userManager->insert($myUser);

                    if ($result) {
                        header('Location:/home/index');
                        return '';
                    } else {
                        $errors['BDD'] = 'Problème sur la base de données.';
                    }
                } else {
                    $errors = $myUser -> getErrors();
                }
            }
        }

        $townsManager = new TownManager();
        $towns = $townsManager->selectAll();

        return $this->twig->render(
            'User/formInscription.html.twig',
            ['towns' => $towns,'errors' => $errors]
        );
    }

    private function issetPost(): ?array
    {
        $myPost = $_POST;
        if (
            isset($myPost['firstname']) &&
            isset($myPost['lastname']) &&
            isset($myPost['phone']) &&
            isset($myPost['street']) &&
            isset($myPost['townId']) &&
            isset($myPost['email'])
        ) {
            return $myPost;
        } else {
            return null;
        }
    }
}
