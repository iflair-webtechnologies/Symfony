<?php

namespace HO\Bundle\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class MailController extends Controller
{
    /**
     * @return array
     * @Route("/mail/notification/received")
     * @Template()
     */
    public function notificationReceivedAction()
    {
        return array();
    }

    /**
     *
     * @Route("/mail/user/created")
     * @return array
     * @param $user
     * @Template()
     */
    public function userCreatedAction($user)
    {
        return array(
            'user' => $user
        );
    }
}
