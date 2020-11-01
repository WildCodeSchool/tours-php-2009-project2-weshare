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
            $firstname = trim($_POST['firstname']);
            $lastname = trim($_POST['lastname']);
            $phone = trim($_POST['phone']);
            $street = trim($_POST['street']);
            $townId = trim($_POST['townId']);
            $email = trim($_POST['email']);

            $userManager = new UserManager();
            $user = [
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'street' => $street,
                'townId' => $townId,
                'email' => $email
            ];
            $userManager->insert($user);
            header('Location:/home/index');
        }

        $townsManager = new TownManager();
        $towns = $townsManager->selectAll();

        return $this->twig->render('User/formInscription.html.twig', ["towns" => $towns]);
    }
}
