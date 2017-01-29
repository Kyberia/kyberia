<?php
namespace AppBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

interface AuthenticatedUserAwareInterface
{
    public function setUserFromSecurityTokenStorage(TokenStorageInterface $tokenStorage);
}
