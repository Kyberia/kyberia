<?php

namespace AppBundle\Controller\Api;

use AppBundle\Service\MailService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;

class MailController extends Controller
{
    /**
     * @return MailService
     */
    private function getMailService()
    {
        return $this->get('app.mail');
    }

    /**
     * @Route("/api/mail/new")
     * @Method("GET")
     */
    public function newMail()
    {
        $mails = $this->getMailService()->getConversationList(['onlyNew' => true]);

        return new Response('asdf');
    }
}
