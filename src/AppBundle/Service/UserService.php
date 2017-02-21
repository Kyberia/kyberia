<?php
namespace AppBundle\Service;

use AppBundle\Entity\Repository\UserRepository;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

class UserService
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param integer $id
     *
     * @return null|User
     */
    public function getUserById($id)
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);

        return $user;
    }

    /**
     * @param string $login
     *
     * @return null|User
     */
    public function getUserByLogin($login)
    {
        $user = $this->userRepository->findOneBy(['login' => $login]);

        return $user;
    }

    //region Password

    public function validatePassword(UserInterface $user, $password)
    {
        $hash = $user->getPassword();

        if (strlen($hash) === 32) {
            // Oldest MD5 passwords
            return hash_equals($hash, md5($password));
        } elseif (strlen($hash) === 80 && $hash[0] !== '$') {
            // Salted SHA1
            $hashParts = str_split($hash, 20);
            $salt = $hashParts[0].$hashParts[3];
            $sha1Hash = $hashParts[1].$hashParts[2];

            return hash_equals($sha1Hash, sha1($salt.md5($password)));
        } else {
            return password_verify($password, $hash);
        }
    }

    //endregion

    //region Followers and following

    /**
     * Get user's followers
     *
     * @param int $userId
     *
     * @return User[]
     */
    public function getFollowers($userId)
    {
        //TODO permissions

        return $this->userRepository->findAllFollowers($userId);
    }

    /**
     * Get users followed by user
     *
     * @param int $userId
     *
     * @return User[]
     */
    public function getFollowing($userId)
    {
        //TODO permissions

        return $this->userRepository->findAllFollowing($userId);
    }

    /**
     * Get active users followed by user
     *
     * @param int $userId
     *
     * @return User[]
     */
    public function getActiveFollowing($userId)
    {
        //TODO permissions

        return $this->userRepository->findActiveFollowing($userId);
    }

    //endregion
}
