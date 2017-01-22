<?php
namespace AppBundle\Entity;

use DateTime;

/**
 * Mail
 */
class Mail extends AbstractEntity
{
    //region Column properties

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    protected $duplicateId;

    /**
     * @var integer
     */
    protected $userId;

    /**
     * @var integer
     */
    protected $userIdFrom;

    /**
     * @var integer
     */
    protected $userIdTo;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var string
     */
    protected $isRead = 'no';

    /**
     * @var DateTime
     */
    protected $createdAt;

    //endregion

    //region Association properties

    /** @var User */
    protected $userFrom;

    /** @var User */
    protected $userTo;

    //endregion

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
    }

    //region Column methods

    public function getId()
    {
        return $this->id;
    }

    public function getDuplicateId()
    {
        return $this->userId;
    }

    public function setDuplicateId($duplicateId)
    {
        $this->duplicateId = $duplicateId;

        return $this;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    public function getUserIdFrom()
    {
        return $this->userIdFrom;
    }

    public function setUserIdFrom($userIdFrom)
    {
        $this->userIdFrom = $userIdFrom;

        return $this;
    }

    public function getUserIdTo()
    {
        return $this->userIdTo;
    }

    public function setUserIdTo($userIdTo)
    {
        $this->userIdTo = $userIdTo;

        return $this;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    public function getIsRead()
    {
        return (bool) $this->isRead === 'yes';
    }

    public function setIsRead($isRead)
    {
        $this->isRead = $isRead ? 'yes' : 'no';

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    //endregion

    //region Association methods

    public function getUserFrom()
    {
        return $this->userFrom;
    }

    public function setUserFrom(User $userFrom)
    {
        $this->userFrom = $userFrom;

        return $this;
    }

    public function getUserTo()
    {
        return $this->userTo;
    }

    public function setUserTo(User $userTo)
    {
        $this->userTo = $userTo;

        return $this;
    }

    //endregion

    //region Custom methods

    public function getRecipientUser()
    {
        if ($this->userId == $this->userIdFrom) {
            return $this->userTo;
        }

        return $this->userFrom;
    }

    public function getRecipientUserId()
    {
        if ($this->userId == $this->userIdFrom) {
            return $this->userIdTo;
        }

        return $this->userIdFrom;
    }

    public function getSenderUser()
    {
        if ($this->userId == $this->userIdFrom) {
            return $this->userFrom;
        }

        return $this->userTo;
    }

    public function getIsReplied()
    {
        return (empty($this->duplicateId) && $this->userId == $this->userIdFrom);
    }

    public function getIsReceived()
    {
        return ($this->userId == $this->userIdTo);
    }

    public function getIsSent()
    {
        return ($this->userId == $this->userIdFrom);
    }

    //endregion
}
