<?php
namespace AppBundle\Service;

use AppBundle\Entity\Repository\UserRepository;
use AppBundle\Entity\User;

class UserService
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

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
