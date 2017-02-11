<?php
namespace AppBundle\Service;

use AppBundle\Entity\Node;
use AppBundle\Security\NodeVoter;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PermissionService
{
    /** @var AuthorizationChecker */
    private $authorizationChecker;

    public function __construct(AuthorizationChecker $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public function canEditNode(Node $node)
    {
        $this->denyAccessUnlessGranted(NodeVoter::EDIT, $node, 'you don\'t have permissions to edit this datanode');
    }

    public function canViewNode(Node $node)
    {
        $this->denyAccessUnlessGranted(NodeVoter::VIEW, $node, 'you don\'t have permissions to view this datanode');
    }

    protected function denyAccessUnlessGranted($attributes, $object = null, $message = 'Access Denied.')
    {
        if (!$this->authorizationChecker->isGranted($attributes, $object)) {
            $exception = new AccessDeniedException($message);
            $exception->setAttributes($attributes);
            $exception->setSubject($object);

            throw $exception;
        }
    }
}
