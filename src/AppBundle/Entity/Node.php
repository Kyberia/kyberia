<?php
namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Node
 */
class Node extends AbstractEntity
{
    const SYSTEM_ACCESS_CRYPTO      = 'crypto';
    const SYSTEM_ACCESS_CUBE        = 'cube';
    const SYSTEM_ACCESS_MODERATED   = 'moderated';
    const SYSTEM_ACCESS_PRIVATE     = 'private';
    const SYSTEM_ACCESS_PUBLIC      = 'public';

    const EXTERNAL_ACCESS_NO    = 'no';
    const EXTERNAL_ACCESS_YES   = 'yes';

    //region Column properties

    /** @var integer */
    protected $id;

    /** @var integer */
    protected $parentId = 0;

    /** @var string */
    protected $name;

    /** @var integer */
    protected $type = 1;

    /** @var integer */
    protected $templateId;

    /** @var string */
    protected $systemAccess = self::SYSTEM_ACCESS_PUBLIC;

    /** @var string */
    protected $externalAccess = self::EXTERNAL_ACCESS_NO;

    /** @var integer */
    protected $childrenCount = 0;

    /** @var integer */
    protected $descendantCount;

    /** @var integer */
    protected $k = 0;

    /** @var integer */
    protected $views;

    /** @var string */
    protected $externalLink;

    /** @var string */
    protected $vector;

    /** @var integer */
    protected $level3 = 0;

    /** @var string */
    protected $content;

    /** @var boolean */
    protected $nl2br = true;

    /** @var \DateTime */
    protected $createdAt;

    /** @var integer */
    protected $createdBy;

    /** @var integer */
    protected $parentCreatedBy;

    /** @var \DateTime */
    protected $updatedAt;

    /** @var \DateTime */
    protected $lastChildCreatedAt = 'CURRENT_TIMESTAMP';

    /** @var \DateTime */
    protected $lastDescendantCreatedAt;

    //endregion

    //region Association properties

    /** @var Node */
    protected $parent;

    /** @var Node[] */
    protected $children;

    /** @var User */
    protected $createdByUser;

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

    public function getParentId()
    {
        return $this->parentId;
    }

    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

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

    public function getTemplateId()
    {
        return $this->templateId;
    }

    public function setTemplateId($templateId)
    {
        $this->templateId = $templateId;

        return $this;
    }

    public function getSystemAccess()
    {
        return $this->systemAccess;
    }

    public function setSystemAccess($systemAccess)
    {
        $this->systemAccess = $systemAccess;

        return $this;
    }

    public function getExternalAccess()
    {
        return $this->externalAccess;
    }

    public function setExternalAccess($externalAccess)
    {
        $this->externalAccess = $externalAccess;

        return $this;
    }

    public function getChildrenCount()
    {
        return $this->childrenCount;
    }

    public function setChildrenCount($childrenCount)
    {
        $this->childrenCount = $childrenCount;

        return $this;
    }

    public function getDescendantCount()
    {
        return $this->descendantCount;
    }

    public function setDescendantCount($descendantCount)
    {
        $this->descendantCount = $descendantCount;

        return $this;
    }

    public function getK()
    {
        return $this->k;
    }

    public function setK($k)
    {
        $this->k = $k;

        return $this;
    }

    public function getViews()
    {
        return $this->views;
    }

    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    public function getExternalLink()
    {
        return $this->externalLink;
    }

    public function setExternalLink($externalLink)
    {
        $this->externalLink = $externalLink;

        return $this;
    }

    public function getVector()
    {
        return $this->vector;
    }

    public function setVector($vector)
    {
        $this->vector = $vector;

        return $this;
    }

    public function getLevel3()
    {
        return $this->level3;
    }

    public function setLevel3($level3)
    {
        $this->level3 = $level3;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function getNl2Br()
    {
        return $this->nl2br;
    }

    public function setNl2Br($nl2br)
    {
        $this->nl2br = $nl2br;

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

    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getParentCreatedBy()
    {
        return $this->parentCreatedBy;
    }

    public function setParentCreatedBy($parentCreatedBy)
    {
        $this->parentCreatedBy = $parentCreatedBy;

        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getLastChildCreatedAt()
    {
        return $this->lastChildCreatedAt;
    }

    public function setLastChildCreatedAt(DateTime $lastChildCreatedAt)
    {
        $this->lastChildCreatedAt = $lastChildCreatedAt;

        return $this;
    }

    public function getLastDescendantCreatedAt()
    {
        return $this->lastDescendantCreatedAt;
    }

    public function setLastDescendantCreatedAt(DateTime $lastDescendantCreatedAt)
    {
        $this->lastDescendantCreatedAt = $lastDescendantCreatedAt;

        return $this;
    }

    //endregion

    //region Association methods

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent(Node $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function addChildren(Node $child)
    {
        $this->children[] = $child;

        return $this;
    }

    public function getCreatedByUser()
    {
        return $this->createdByUser;
    }

    public function setCreatedByUser(User $createdByUser)
    {
        $this->createdByUser = $createdByUser;

        return $this;
    }

    //endregion

    //region Custom methods

    public function incrementViews($amount = 1)
    {
        $this->views += $amount;

        return $this;
    }

    public function hasExternalAccess()
    {
        return $this->externalAccess === static::EXTERNAL_ACCESS_YES;
    }

    public function isModerated()
    {
        return $this->systemAccess === static::SYSTEM_ACCESS_MODERATED;
    }

    public function isPrivate()
    {
        return $this->systemAccess === static::SYSTEM_ACCESS_PRIVATE;
    }

    public function isPublic()
    {
        return $this->systemAccess === static::SYSTEM_ACCESS_PUBLIC || empty($this->systemAccess);
    }

    //endregion
}
