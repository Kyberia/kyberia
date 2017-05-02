<?php
namespace AppBundle\Security;

use AppBundle\Entity\User;
use AppBundle\Service\UserService;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class FormUserProvider implements UserProviderInterface
{
    /** @var UserService */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @inheritdoc
     *
     * @param string $username Compound username [type:username]
     *
     * @return null|User
     */
    public function loadUserByUsername($username)
    {
        list($type, $username) = explode(':', $username, 2);

        $user = null;
        switch ($type) {
            case UserCredentials::TYPE_ID:
                $user = $this->userService->getUserById($username);
                break;
            case UserCredentials::TYPE_NAME:
                $user = $this->userService->getUserByLogin($username);
                break;
            default:
                throw new \InvalidArgumentException('Invalid user credentials type');
        }

        if ($user === null) {
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $username));
        }

        return $user;
    }

    /**
     * @inheritdoc
     *
     * @param UserInterface $user
     *
     * @throws UnsupportedUserException if the account is not supported
     *
     * @return UserInterface
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$this->supportsClass(get_class($user))) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        $user = $this->userService->getUserById($user->getId());

        return $user;
    }

    /**
     * Whether this provider supports the given user class.
     *
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return $class === User::class;
    }
}
