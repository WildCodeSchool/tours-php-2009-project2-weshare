<?php
namespace App\Controller;

use App\Model\UserManager;
use App\Model\TownManager;

/**
 * Class UserController
 *
 */
class UserController extends AbstractController
{

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['firstname']) && isset($_POST['lastname']) &&
        isset($_POST['phone']) && isset($_POST['street']) && isset($_POST['townId'])
        && isset($_POST['email'])) {
            $userManager = new UserManager();
            $user = [
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'phone' => $_POST['phone'],
                'street' => $_POST['street'],
                'townId' => $_POST['townId'],
                'email' => $_POST['email']
            ];
            $userManager->insert($user);
            header('Location:/home/index');
        }

        $townsManager = new TownManager();
        $towns = $townsManager->selectAll();

        return $this->twig->render('User/formInscription.html.twig', ["towns" => $towns]);
    }
}
