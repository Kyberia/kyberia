<?php
namespace AppBundle\Helper;

use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;

class SecurityHelper extends AbstractSymfonyHelper
{
    /**
     * Pretend user is logged in
     *
     * @param $username
     */
    public function amLoggedInAs($username)
    {
        $firewallContext = 'main';

        /** @var \AppBundle\Entity\Repository\UserRepository $userRepository */
        $userRepository = $this->getSymfonyModule()->grabService('app.entity.repository.user');

        /** @var \Symfony\Component\HttpFoundation\Session\Session $session */
        $session = $this->getSymfonyModule()->grabService('session');

        // Fetch user
        $user = $userRepository->findOneBy(['login' => $username]);

        // Create token and save to session and cookie
        $token = new PostAuthenticationGuardToken($user, $firewallContext, $user->getRoles());

        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookieJar = $this->getSymfonyModule()->client->getCookieJar();
        $cookieJar->set(new Cookie($session->getName(), $session->getId()));
    }

    /**
     * Checks if the attributes are granted against the current authentication token
     *
     * @param mixed $attributes
     */
    public function seeIsGranted($attributes)
    {
        /** @var \Symfony\Component\Security\Core\Authorization\AuthorizationChecker $authorizationChecker */
        $authorizationChecker = $this->getSymfonyModule()->grabService('security.authorization_checker');
        $this->assertTrue($authorizationChecker->isGranted($attributes));
    }
}
