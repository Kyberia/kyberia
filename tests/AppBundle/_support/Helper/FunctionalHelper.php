<?php
namespace AppBundle\Helper;

use Codeception\Module;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;

class FunctionalHelper extends Module
{
    /**
     * Sets whether to automatically follow redirects or not
     *
     * @param bool $followRedirect
     */
    public function followRedirects($followRedirect = true)
    {
        $this->getSymfonyModule()->client->followRedirects($followRedirect);
    }

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
     * @return Module\Symfony
     */
    private function getSymfonyModule()
    {
        /** @var \Codeception\Module\Symfony $symfony */
        $symfony = $this->getModule('Symfony');

        return $symfony;
    }
}
