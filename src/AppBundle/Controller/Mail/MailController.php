<?php
namespace AppBundle\Controller\Mail;

use AppBundle\Form\Type\SendMailFormType;
use AppBundle\Service\MailService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/", name="mail.index")
     * @Method({"GET"})
     */
    public function indexAction(Request $request)
    {
        $mails = $this->getMailService()->getConversationList();

        return $this->render('mail/index.html.twig', [
            'mails' => $mails,
        ]);
    }

    /**
     * @Route("/{userId}", name="mail.view", requirements={"userId": "\d+"})
     * @Method({"GET", "POST"})
     */
    public function viewAction(Request $request, $userId)
    {
        $mails = $this->getMailService()->getMessagesByRecipientUserId($userId);

        $form = $this->createForm(SendMailFormType::class, null, []);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $this->getMailService()->sendMessage($userId, $form->get('text')->getData());

            return $this->redirectToRoute('mail.view', ['userId' => $userId]);
        }
        else {
            $this->getMailService()->markConversationAsRead($userId);
        }

        return $this->render('mail/view.html.twig', [
            'mails' => $mails,
            'form' => $form->createView(),
        ]);
    }
}
