<?php
namespace AppBundle\Service;

use AppBundle\Entity\Repository\UserRepository;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

class UserService
{
    /** @var EncoderFactory */
    private $encoderFactory;

    /** @var UserRepository */
    private $userRepository;

    public function __construct(EncoderFactory $encoderFactory, UserRepository $userRepository)
    {
        $this->encoderFactory = $encoderFactory;
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

    public function changePassword(User $user, $password)
    {
        $encoder = $this->encoderFactory->getEncoder($user);

        $user->setPassword($encoder->encodePassword($password, ''));
        $user->setDatePasswordChanged(new \DateTime());

        $this->userRepository->persist($user);
    }

    public function validatePassword(User $user, $password)
    {
        $encoder = $this->encoderFactory->getEncoder($user);

        return $encoder->isPasswordValid($user->getPassword(), $password, '');
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
