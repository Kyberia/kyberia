<?php
namespace AppBundle\DI;

use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

trait AuthenticatedUserAwareTrait
{
    /** @var \AppBundle\Entity\User */
    protected $authenticatedUser;

    public function setUserFromSecurityTokenStorage(TokenStorageInterface $tokenStorage)
    {
        if (($token = $tokenStorage->getToken()) === null) {
            throw new \InvalidArgumentException('Token missing');
        }

        if (!(($user = $token->getUser()) instanceof User)) {
            throw new \InvalidArgumentException('Invalid user');
        }

        $this->authenticatedUser = $user;
    }
}
