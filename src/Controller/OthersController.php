<?php

/**
 * Created by Wcs.
 * User: Quentin
 * Date: 05/11/20
 */

namespace App\Controller;

/**
 * Class OthersController
 *
 */
class OthersController extends AbstractController
{
    public function presentation()
    {
        return $this->twig->render('Others/presentationTeam.html.twig');
    }

    public function legalMentions()
    {
        return $this->twig->render('Others/legalMention.html.twig');
    }

    public function partners()
    {
        return $this->twig->render('Others/partners.html.twig');
    }
}
