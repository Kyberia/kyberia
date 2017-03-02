<?php
namespace AppBundle\Controller;

use AppBundle\Form\Type\LoginFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AuthController extends Controller
{
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        $form = $this->createForm(LoginFormType::class, [
            'username' => $authenticationUtils->getLastUsername(),
        ], []);

        return $this->render('auth/login.html.twig', [
            'form' => $form->createView(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }
}
