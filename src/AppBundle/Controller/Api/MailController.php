<?php

namespace AppBundle\Controller\Api;

use AppBundle\Service\MailService;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class MailController extends FOSRestController
{
    /**
     * @return MailService
     */
    private function getMailService()
    {
        return $this->get('app.mail');
    }

    /**
     * @Rest\Get("/api/mail/new")
     * @Rest\View(serializerGroups={"list"})
     */
    public function newMail()
    {
        $mails = $this->getMailService()->getConversationList(['onlyNew' => true]);

        return $mails;
    }
}
