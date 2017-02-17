<?php
namespace AppBundle\Twig;

use AppBundle\Service\UserService;

class AppExtension extends \Twig_Extension
{
    /** @var UserService */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('friends_online', [$this, 'friendsOnline']),
        ];
    }

    //region Functions

    public function friendsOnline($userId)
    {
        return $this->userService->getActiveFollowing($userId);
    }

    //endregion
}
