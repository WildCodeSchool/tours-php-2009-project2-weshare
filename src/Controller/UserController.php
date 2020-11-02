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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['phone'])
            && isset($_POST['street']) && isset($_POST['townId']) && isset($_POST['email'])) {
                $firstname = trim($_POST['firstname']);
                $lastname = trim($_POST['lastname']);
                $phone = trim($_POST['phone']);
                $street = trim($_POST['street']);
                $townId = trim($_POST['townId']);
                $email = trim($_POST['email']);

                $errors = [];

                if (strlen($firstname) > 50) {
                    $errors['firstname'] = 'The firstname is too long, maximum 50 characters';
                }
                if (strlen($firstname) <= 0) {
                    $errors['firstname'] = 'The firstname is too short, minimum 1 character';
                }
                if (strlen($lastname) > 50) {
                    $errors['lastname'] = 'The lastname is too long, maximum 50 characters';
                }
                if (strlen($lastname) <= 0) {
                    $errors['lastname'] = 'The lastname is too short, minimum 1 character';
                }
                if (strlen($phone) != 10) {
                    $errors['phone'] = 'The phone num has to be 10 numbers';
                }

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
        }

        $townsManager = new TownManager();
        $towns = $townsManager->selectAll();

        return $this->twig->render('User/formInscription.html.twig', ["towns" => $towns]);
    }
}
