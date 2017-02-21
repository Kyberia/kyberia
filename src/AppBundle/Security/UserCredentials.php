<?php
namespace AppBundle\Security;

class UserCredentials
{
    const TYPE_ID   = 'id';
    const TYPE_NAME = 'name';

    /** @var string */
    private $password;

    /** @var string */
    private $type;

    /** @var string */
    private $username;

    /**
     * UserCredentials constructor.
     *
     * @param string $username
     * @param string $password
     * @param string $type
     */
    public function __construct($username, $password, $type = self::TYPE_NAME)
    {
        $this->password = $password;
        $this->type = $type;
        $this->username = $username;
    }

    public function getUsernameCompound()
    {
        return sprintf('%s:%s', $this->type, $this->username);
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }
}
