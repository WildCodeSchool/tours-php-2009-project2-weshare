<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

class HomeController extends AbstractController
{

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        /* en attente de la classe DemandeManager
        *$itemManager = new ItemManager();
        *$item = $itemManager->selectOneById($id);
        *
        *if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        *    $item['title'] = $_POST['title'];
        *    $itemManager->update($item);
        *}*/

        return $this->twig->render('Home/index.html.twig');
    }
    
    public function seeDemands()
    {
        return $this->twig->render('Home/see_demands.html.twig');
    }
}
