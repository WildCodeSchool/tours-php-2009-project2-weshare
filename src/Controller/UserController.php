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

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['firstname']) && isset($_POST['lastname'])
        && isset($_POST['phone']) && isset($_POST['street']) && isset($_POST['townId']) && isset($_POST['email'])) {
            $myUser = new User(
                $_POST['firstname'],
                $_POST['lastname'],
                $_POST['phone'],
                $_POST['street'],
                $_POST['townId'],
                $_POST['email']
            );

            if ($myUser->isValid()) {
                $userManager = new UserManager();

                $userManager->insert($myUser);
                header('Location:/home/index');
            } else {
                $errors = $myUser -> getErrors();
            }
        }

        $townsManager = new TownManager();
        $towns = $townsManager->selectAll();

        return $this->twig->render(
            'User/formInscription.html.twig',
            ['towns' => $towns,'errors' => $errors]
        );
    }
}
