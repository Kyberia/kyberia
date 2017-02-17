<?php
namespace AppBundle\Entity;

/**
 * User relation
 */
class UserRelation extends AbstractEntity
{
    const TYPE_BOOK         = 1;
    const TYPE_FOOK         = -1;
    const TYPE_FRIEND       = 2;
    const TYPE_IGNORE       = -2;
    const TYPE_IGNORE_MAIL  = -3;

    //region Column properties

    /** @var integer */
    protected $id;

    /** @var integer */
    protected $userId;

    /** @var integer */
    protected $nodeId;

    /** @var integer */
    protected $type;

    //endregion

    //region Association properties

    //endregion

    //region Column methods

    public function getId()
    {
        return $this->id;
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

    public function getNodeId()
    {
        return $this->nodeId;
    }

    public function setNodeId($nodeId)
    {
        $this->nodeId = $nodeId;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    //endregion

    //region Association methods

    //endregion

    //region Custom methods

    //endregion
}
