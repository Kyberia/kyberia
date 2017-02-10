<?php
namespace AppBundle\Entity;

use DateTime;

/**
 * NodeAccess
 */
class NodeAccess extends AbstractEntity
{
    const BOOKMARK_NO   = 'no';
    const BOOKMARK_YES  = 'yes';

    const PERMISSION_ACCESS     = 'access';
    const PERMISSION_BAN        = 'ban';
    const PERMISSION_EXECUTE    = 'execute';
    const PERMISSION_MASTER     = 'master';
    const PERMISSION_OP         = 'op';
    const PERMISSION_SILENCE    = 'silence';

    const K_NO  = 'no';
    const K_YES = 'yes';

    //region Column properties

    /** @var integer */
    protected $nodeId;

    /** @var integer */
    protected $userId;

    /** @var string */
    protected $bookmark = self::BOOKMARK_NO;

    /** @var string */
    protected $permission;

    /** @var integer */
    protected $nodeUserSubchildCount;

    /** @var DateTime */
    protected $lastVisitAt;

    /** @var integer */
    protected $visits;

    /** @var integer */
    protected $bookmarkCategoryNodeId;

    /** @var string */
    protected $givenK = self::K_NO;

    //endregion

    //region Association properties

    /** @var Node */
    protected $node;

    /** @var User */
    protected $user;

    /** @var Node */
    protected $bookmarkCategory;

    //endregion

    //region Column methods

    public function getNodeId()
    {
        return $this->nodeId;
    }

    public function setNodeId($nodeId)
    {
        $this->nodeId = $nodeId;

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

    public function getBookmark()
    {
        return $this->bookmark;
    }

    public function setBookmark($bookmark)
    {
        $this->bookmark = $bookmark;

        return $this;
    }

    public function getPermission()
    {
        return $this->permission;
    }

    public function setPermission($permission)
    {
        $this->permission = $permission;

        return $this;
    }

    public function getNodeUserSubchildCount()
    {
        return $this->nodeUserSubchildCount;
    }

    public function setNodeUserSubchildCount($nodeUserSubchildCount)
    {
        $this->nodeUserSubchildCount = $nodeUserSubchildCount;

        return $this;
    }

    public function getLastVisitAt()
    {
        return $this->lastVisitAt;
    }

    public function setLastVisitAt($lastVisitAt)
    {
        $this->lastVisitAt = $lastVisitAt;

        return $this;
    }

    public function getVisits()
    {
        return $this->visits;
    }

    public function setVisits($visits)
    {
        $this->visits = $visits;

        return $this;
    }

    public function getBookmarkCategoryNodeId()
    {
        return $this->bookmarkCategoryNodeId;
    }

    public function setBookmarkCategoryNodeId($bookmarkCategoryNodeId)
    {
        $this->bookmarkCategoryNodeId = $bookmarkCategoryNodeId;

        return $this;
    }

    public function getGivenK()
    {
        return $this->givenK;
    }

    public function setGivenK($givenK)
    {
        $this->givenK = $givenK;

        return $this;
    }

    //endregion

    //region Association methods

    public function getNode()
    {
        return $this->node;
    }

    public function setNode(Node $node)
    {
        $this->node = $node;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    public function getBookmarkCategory()
    {
        return $this->bookmarkCategory;
    }

    public function setBookmarkCategory(Node $bookmarkCategory)
    {
        $this->bookmarkCategory = $bookmarkCategory;

        return $this;
    }

    //endregion
}
