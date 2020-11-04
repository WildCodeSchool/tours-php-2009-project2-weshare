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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['phone'])
            && isset($_POST['street']) && isset($_POST['townId']) && isset($_POST['email'])) {
                $myUser = new User(
                    $_POST['firstname'],
                    $_POST['lastname'],
                    $_POST['phone'],
                    $_POST['street'],
                    $_POST['townId'],
                    $_POST['email']
                );

                $errors = $myUser -> isOk();

                if (empty($errors)) {
                    $userManager = new UserManager();
                    $user = [
                        'firstname' => $myUser->getFirstname(),
                        'lastname' => $myUser->getLastname(),
                        'phone' => $myUser->getPhone(),
                        'street' => $myUser->getStreet(),
                        'townId' => $myUser->getTownId(),
                        'email' => $myUser->getEmail()
                    ];

                    $userManager->insert($user);
                    header('Location:/home/index');
                }
            }
        }

        $townsManager = new TownManager();
        $towns = $townsManager->selectAll();

        return $this->twig->render('User/formInscription.html.twig', ["towns" => $towns]);
    }
}
